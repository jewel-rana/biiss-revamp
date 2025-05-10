<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Employee;
use Auth;
use App\Country;
use App\Role;
use DB;
use Hash;
use App\BookIssue;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search=trim($request->input('search'));
        $query = User::with('issuedBooks')->withCount('issuedBooks');
        if( isset( $_GET['search'] )  ) :
            $query->where('name', 'like', '%'.$search.'%');
            $query->orWhere('email', 'like', '%'.$search.'%');
            $query->orWhere('contact_number', 'like', '%'.$search.'%');
            $query->orWhere('address', 'like', '%'.$search.'%');
        endif;
        $members = $query->orderBy('id','DESC')->paginate(10);

        $title = 'All Members';
        return view('users.index',compact('members', 'title'))->with('i', ($request->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {



        $roles = Role::pluck('display_name','id');
        $title = 'Add new member';


        return view('users.create',compact('roles', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => ( in_array( array(1), $request->roles ) ) ? 'same:confirm-password' : '',
            'roles' => 'required',
            'account_id' => 'required|unique:users,account_id'
        ]);

        $input = $request->all();

        $user = new User();
        $user->account_id = $request->account_id;
        $user->name=$input['name'];
        $user->email=$input['email'];
        $user->password=Hash::make($input['password']);
        $user->contact_number=$input['contact_number'];
        $user->address=$input['address'];


        if($request->file('avatar')) {
            $profile_image = $request->file('avatar');
            $upload = 'uploads/profile';

            $extension = $profile_image->getClientOriginalExtension();
            $profile_image_name = time() . "." . $extension;
            $success = $profile_image->move($upload, $profile_image_name);

            $input['avatar'] = $profile_image_name;
            $user->avatar=$input['avatar'];
        }

        if($user->save()) {
            foreach ($request->input('roles') as $key => $value) {
                $user->attachRole($value);
            }

        }

        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $member = User::find( $id );
        $pageTitle = '404 Not found!';

        if( empty( $member ) )
            return view('errors.404', compact('pageTitle'));

        $issuedBooks = \App\LibraryIssue::with('item')->where('user_id',$id)->orderBy('id','DESC')->get();

        $pageTitle = 'Member Profile';
        return view('dashboard.member.profile',compact( 'member', 'issuedBooks', 'pageTitle' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $member = User::find($id);
        $title = 'Edit Member';

        $roles = Role::pluck('display_name','id');
        $userRole = $member->roles->pluck('id','id')->toArray();

        return view('users.edit',compact('member','roles','userRole', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles' => 'required',
            'account_id' => 'required|unique:users,account_id,' . $id
        ]);

        $input = $request->all();

        $user = User::find($id);
        $user->account_id = ( $request->account_id ) ? $request->account_id : $user->account_id;
        $user->name=$input['name'];
        $user->email=$input['email'];
        if(!empty($input['password'])) {
            $user->password = Hash::make($input['password']);
        }
        $user->contact_number=$input['contact_number'];
        $user->address=$input['address'];

        if($request->file('avatar')) {
            if($user->avatar!=""){
                $upload_file="uploads/profile/".$user->avatar;
                //unlink($upload_file);
            }
            $profile_image = $request->file('avatar');
            $upload = 'uploads/profile';

            $extension = $profile_image->getClientOriginalExtension();
            $profile_image_name = time() . "." . $extension;
            $success = $profile_image->move($upload, $profile_image_name);

            $input['avatar'] = $profile_image_name;
            $user->avatar=$input['avatar'];
        }


        $user->save();

        DB::table('role_user')->where('user_id',$id)->delete();

        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);

        if( !$user )
            return redirect()->route('users.index')->with('error','Sorry! user not found.');

        if( Auth::user()->id == $user->id )
            return redirect()->route('users.index')->with('error','Sorry! you cannot delete your own account.');

        if( $user->hasRole('admin') )
            return redirect()->route('users.index')->with('error','Sorry! you cannot delete Admin account. Because This account has many history and activities');

        if( $user->delete() ){
            $upload_file="uploads/profile/".$user->avatar;
            if( \File::exists( $upload_file ) ) {
                    unlink($upload_file);
            }

            return redirect()->route('users.index')
                ->with('success','User deleted successfully');
        } else {
            return redirect()->route('users.index')
                ->with('error','Cannot delete user.');
        }
        
    }
}
