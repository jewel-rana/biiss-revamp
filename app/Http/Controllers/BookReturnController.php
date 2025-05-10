<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookIssue;
use App\BookReturn;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use DB;
use Carbon\Carbon;

class BookReturnController extends Controller
{
    public function index(Request $request)
    {

        $items = BookReturn::with(['issue', 'book', 'member', 'admin'])->orderBy('id','DESC')->get();

        // dd( $items );
        
        $title = 'Issues Returned';
        return view('book_return.index',compact('items', 'title'));
    }


    public function create(){

        $insertData['member'] = User::pluck('name','id');
        $insertData['book_issue'] = BookIssue::where('is_returned',0)->orderBy('id','DESC')->pluck('book_issue_code','id');

        return view('book_return.create',compact('insertData'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $this->validate($request, [
            'book_issue_code' => 'required',
            'user_id' => 'required',
        ]);

        $data = $request->all();
        $admin_id = Auth::user()->id;


        $data2['cities'] = DB::table("book_issue")
            ->where("book_issue_code",$data['book_issue_code'])
            ->first();
        $data2['book']=DB::table("books")->where('id', $data2['cities']->book_id)->first();

        $CheckBookIssue=BookIssue::where('book_issue_code',$data['book_issue_code'])->where('is_returned', 0)->first();

        if(count($CheckBookIssue)>0){
            $bookReturn = new BookReturn();
            //$bookReturn->book_issue_id = $data['book_issue_code'];
            $bookReturn->book_issue_id = $CheckBookIssue->id;
            $bookReturn->user_id = $data['user_id'];
            $bookReturn->admin_id = $admin_id;
            //$bookReturn->type = $data['type'];
            $bookReturn->return_date = $data['return_date'];

           /* $end_issue_date=$data['end_issue_date'];
            $return_date=$data['return_date'];*/

            $end_issue =Carbon::parse($data['end_issue_date']);
            $return_date =Carbon::parse($data['return_date']);

            if($return_date->gt($end_issue)){
                $dat=$return_date->diffInDays($end_issue);
                $bookReturn->late_count = $dat;
            }else{
                $bookReturn->late_count = 0;
            }


            $saved = $bookReturn->save();
            if($saved){
                $CheckBookIssue->is_returned=1;
                $CheckBookIssue->save();

                return json_encode($data2);

               // return response()->json($bookReturn);
               // return redirect()->route('book_return.index')->with('success','Book return successfully');
            }
            return redirect()->route('book_return.index')->with('error','Something went wrong!!!');
        }else{
            return redirect()->route('book_return.index')->with('error','Something went wrong!!!');
        }

    }

    public function show($id){

        $data['item'] = BookReturn::find($id);

        $data['title'] = 'Return Details';
        return view('dashboard.library.return.show',$data);
    }

    public function destroy($id){

        $book = BookReturn::find($id);

        $book->delete();

        return redirect()->route('book_return.index')->with('success','Return deleted successfully');
    }


    public function myformAjax($id)
    {


        $data['cities'] = DB::table("book_issue")
            ->where("book_issue_code",$id)
            ->first();
        $data['book']=DB::table("books")->where('id', $data['cities']->book_id)->first();

        //dd($cities->book_id);
        //exit();

        return json_encode($data);
    }

    public function myformAjaxQr($id){

        $data['cities'] = DB::table("book_issue")
            ->where("copy_number",$id)
            ->first();
        $data['book']=DB::table("books")->where('id', $data['cities']->book_id)->first();



        return json_encode($data);
    }


    public function returnWeekIndex(Request $request){

        $items = BookReturn::where('created_at', '>=', Carbon::now()->startOfWeek())->take(10)->paginate(10);


        return view('book_return.return_week',compact('items'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

}
