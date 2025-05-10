<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use App\BookIssue;
use Illuminate\Support\Facades\Auth;
use DB;

class BookIssueController extends Controller
{
    public function index(Request $request){

        $search=trim($request->input('search'));

        $query = BookIssue::with(['book', 'member'])->where('is_returned',0);

        if( isset( $_GET['search'] ) ) :
            $query->where('book_title', 'like', '%'.$search.'%');
            $query->orWhere('copy_number', 'like', '%'.$search.'%');
            $query->orWhere('user_name', 'like', '%'.$search.'%');
            $query->orWhere('start_date', 'like', '%'.$search.'%');
        endif;

        //filter type
        $type = 'All';
        if( isset( $_GET['type'] ) && $_GET['type'] != null ) :
            $type = $_GET['type'];
            $today = date('Y-m-d');
            if( $type == 'expire' ) :
                $query->where('end_date', '<', $today);
            endif;

            if( $type == 'active' ) :
                $query->where('end_date', '>=', $today);
            endif;
        endif;
        $data['issues'] = $query->get();

        // dd($data['issues']);
        $data['title'] = ucwords($type, '_') . ' Issues';

        return view('dashboard.library.issue.index', $data);
    }

    public function takereturn( $bookId )
    {
        $copynum = isset( $_GET['copy'] ) ? $_GET['copy'] : '';

        //get issue info
        $issue = \App\BookIssue::where(['book_id' => $bookId, 'copy_number' => $copy])->get();

        if( !empty( $issue ) ) :
            return back();
        else :
            return back();
        endif;

    }

    public function create($id = null){

        $type = ( isset( $_GET['type'] ) ) ? $_GET['type'] : 'book';

        $data['member'] = User::pluck('name','id');

        $data['item'] = ( $id ) ? Book::find( $id ) : '';
        $data['type'] = $type;
        $data['title'] = 'New ' . ucfirst( $type ) . ' Issue';

        return view('dashboard.library.issue.create', $data );
    }


    public function store(Request $request){
       $this->validate($request, [
            'book_id' => 'required',
            'user_id' => 'required',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',

        ]);

        $data = $request->all();

        $admin_id = Auth::user()->id;

        $book_id = $data['book_id'];
        $bookInfo = Book::where('id',$book_id)->first();
        if(count($bookInfo)>0){
            $book_title = $bookInfo->title;
        } else {
            $book_title = 'empty';
        }
        $user_id = $data['user_id'];
        $userInfo = User::where('id',$user_id)->first();
        if(count($userInfo)>0){
            $user_name = $userInfo->name;
        } else {
            $user_name = 'empty';
        }

        //$book_issue_code = $user_name.'_'.$book_title.'_'.md5(time());

        $bookIssues = new BookIssue();
        $bookIssues->book_issue_code = $book_title.'_'.$data['copy_number'].'_'.$user_name;
        $bookIssues->book_id = $data['book_id'];
        $bookIssues->book_title = $book_title;
        $bookIssues->copy_number = $data['copy_number'];
        $bookIssues->user_id = $data['user_id'];
        $bookIssues->user_name = $user_name;
        $bookIssues->admin_id = $admin_id;
        $bookIssues->type = $data['type'];
        $bookIssues->start_date = $data['start_date'];
        $bookIssues->end_date = $data['end_date'];
        $bookIssues->status = 1;
        $bookIssues->is_returned = 0;
        $saved = $bookIssues->save();
        if($saved){

            $bookInfo = Book::where('id',$data['book_id'])->first();
            $finalIssueCount = (int) $bookInfo->issue_count +1;
            $update = Book::where('id',$bookInfo->id)->update(['issue_count'=>$finalIssueCount]);


            return redirect()->route('book_issue.index')->with('success','Book issued successfully');
        }
        return redirect()->route('book_issue.index')->with('error','Something went wrong!!!');

    }

    public function edit($id){
        $data['member'] = User::pluck('name','id');


        $data['book'] = Book::pluck('title','id');

        $data['item']  = BookIssue::find($id);

        return view('book_issue.edit',$data);
    }

    public function update(Request $request, $id){

        $data = $request->all();
        $admin_id = Auth::user()->id;


        $book_id = $data['book_id'];
        $bookInfo = Book::where('id',$book_id)->first();
        if(count($bookInfo)>0){
            $book_title = $bookInfo->title;
        } else {
            $book_title = 'empty';
        }
        $user_id = $data['user_id'];
        $userInfo = User::where('id',$user_id)->first();
        if(count($userInfo)>0){
            $user_name = $userInfo->name;
        } else {
            $user_name = 'empty';
        }
        $data['user_name'] = $user_name;
        $data['book_title'] = $book_title;

        BookIssue::find($id)->update($data);

        return redirect()->route('book_issue.index')->with('success','Re-Issue Done!!!');
    }

    //new
    public function expiredIndex(Request $request){

        $today = date('Y-m-d');

        $items = BookIssue::where('is_returned','0')->whereDate('end_date','<',$today)->paginate(10);

        return view('book_issue.expire_index',compact('items'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function show( $id ) {
        $issue = BookIssue::find( $id );
        $title = 'Issue Details';
        return view('dashboard.library.issue.show', compact('title', 'issue'));
    }

    public function mychangecopyAjax( $id )
    {
        $bookinfo=DB::table("books")->where('id', $id)->first();

        $bookscopy = json_decode($bookinfo->qr_string);

        $bookIssueCopyNumer = BookIssue::where('is_returned',0)->where('book_id',$id)->get();

        if(count($bookIssueCopyNumer)>0){
            foreach ($bookIssueCopyNumer as $singlekey){
                unset( $bookscopy[array_search( $singlekey->copy_number, $bookscopy )] );
            }
        }

        $data['bookscopy'] = $bookscopy;

        return json_encode($data['bookscopy']);
    }


    public function destroy($id)
    {
        $bookIssue=BookIssue::find($id);

        $bookIssue->delete();

        return redirect()->route('book_issue.index')->with('success','Book issue deleted successfully');
    }

    public function getDataByQrString($qr_string){

        $bookinfo = Book::where('qr_string_unique', $qr_string)->first();

        // $bookscopy = json_decode($bookinfo['qr_string']);

        // $bookIssueCopyNumer = BookIssue::where('is_returned',0)->where('book_id',$bookinfo['id'])->get();

        // if( count( $bookIssueCopyNumer ) > 0 ) {
        //     foreach ( $bookIssueCopyNumer as $singlekey ) {
        //         unset( $bookscopy[array_search( $singlekey->copy_number, $bookscopy )] );
        //     }
        // }

        // $data['bookscopy'] = $bookscopy;
        // if(count($data['bookscopy'])>0){
        //     $data['book_title'] = $bookinfo->title;
        //     $data['book_id'] = $bookinfo->id;
        // } else {
        //     $data['book_title'] = '';
        //     $data['book_id'] = '';
        // }


        return json_encode($bookinfo);
    }

    public function extend( $id )
    {
        $data['item'] = BookIssue::with(['member', 'book'])->find( $id );
        $data['title'] = 'Extend validity of Issue';

        return view('dashboard.library.issue.extend', $data );
    }







}
