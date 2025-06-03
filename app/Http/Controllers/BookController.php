<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class BookController extends Controller
{
    public function index( Request $request ) {

        $title = (isset( $_GET['title'] ) ) ? trim($_GET['title']) : '';
        $author = (isset( $_GET['author'] ) ) ? trim($_GET['author']) : '';
        $category = (isset( $_GET['category'] ) ) ? trim($_GET['category']) : '';

        //if type not supplied then set default type is "Book"
        $type = ( isset( $_GET['type'] ) && $_GET['type'] != null ) ? strtolower( $_GET['type'] ) : 'book';

        $query = Book::where('title', '!=', '');

        //if user provide type then use this condition
        if( isset( $_GET['type'] ) && $_GET['type'] != '' )
            $query->where( 'type', $type );

        //if title parameter supplied then run this condition
        if( isset( $_GET['title'] ) && !empty( $_GET['title'] ) )
            $query->where('title', 'LIKE', "%{$title}%");

        //if author parameter supplied then run this condition
        if( isset( $_GET['author'] ) && !empty( $_GET['author'] ) )
            $query->where('author','LIKE', "%{$author}%");

        //sort by First letter of Title
        if( isset( $_GET['letter_sort'] ) ) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter.'%');
        endif;

        //if category filter then run this condition
        // if( !empty( $title ) ) {
        //     $query->orWhere('title', 'like', '%'.$title.'%');
        // }

        $data['items'] = $query->orderBy('title', 'asc')->paginate(10);
        $data['pageTitle'] = 'Library Management : ';
        $data['pageTitle'] .= ( $type == 'seminar' ) ? ucfirst( $type ) . ' Proceeding' : ucfirst($type) . 's';
        if( \Illuminate\Support\Facades\Request::segment(3) == 'search' )
            $data['pageTitle'] = 'Library Management : Search';
        $data['title'] = 'Library Management : ' . ucfirst( $type ) . 's';
        $data['type'] = $type;

        // dd( $data );

        return view('dashboard.library.index', $data);

    }

    public function search(Request $request )
    {
        $results = Book::filter($request)->orderBy('title', 'asc')->paginate(10);
        return view('search', compact('results'));
    }

    public function create() {
        $data['type'] = ( isset( $_GET['type'] ) ) ? $_GET['type'] : 'book';
        $data['category'] = Category::pluck('name','id');
        $data['title'] = 'Add new ' . ucfirst( $data['type'] );
        $data['subview'] = 'create' . $data['type'];
        return view('dashboard.library.create', $data);
    }

    public function storebook(Request $request ){

        dd( $request->all() );
        // $this->validate($request, [
        //     'title' => 'required',
        //     'category' => 'required',
        //     'copy' => 'required'
        // ]);
        // $data = $request->all();


        // $copy = $data['copy'];
        // if(!isset($copy)){
        //     $copy = 1;
        // }

        // $qr = '';

        // for ($x = 0; $x < $copy; $x++) {
        //     $y = $x+1;
        //     $qr[] = 'c-'.$y.'-'.time();
        // }




        // $data['qr_string_unique'] = time();
        // $data['qr_string'] = json_encode($qr);
        // $data['admin_id'] = Auth::user()->id;
        // $data['category'] = json_encode($data['category']);
        // if(isset($data['taggles'])){
        //     $data['taggles'] = json_encode($data['taggles']);
        // }


        // if($request->file('cover_photo')) {
        //     $cover_photo = $request->file('cover_photo');
        //     $upload = 'uploads/books';

        //     $extension = $cover_photo->getClientOriginalExtension();
        //     $cover_photo_name = md5(time()) . "." . $extension;
        //     $success = $cover_photo->move($upload, $cover_photo_name);

        //     $data['cover_photo'] = $cover_photo_name;

        // }

        // if($request->file('e_book')) {
        //     $e_book = $request->file('e_book');
        //     $upload = 'uploads/books';

        //     $extension = $e_book->getClientOriginalExtension();
        //     $e_book_name = time() . "." . $extension;
        //     $success = $e_book->move($upload, $e_book_name);

        //     $data['file'] = $e_book_name;

        // }


        // $RetData = Book::create($data);

        // $returnData = [];

        // if( $data['type'] == 'book'){
        //     $message = 'Book created successfully!';
        // }

        // if( $data['type'] == 'journal'){
        //     $message = 'Journal created successfully!';
        // }

        // if( $data['type'] == 'seminar'){
        //     $message = 'Seminar created successfully!';
        // }

        // $returnData =[
        //     'message'=> $message,
        //     'Qr_DD_PRINT'=>$RetData->qr_string,
        // ];


        // return redirect()->route('book.index')->with('update_success',$returnData);
    }


    public function show($id){

        //load data
        $item = Book::findOrFail($id);
        $title = 'Details';

        //load view
        return view('dashboard.library.single', compact( 'item', 'title' ));
    }

    public function edit($id)
    {
        $data['category'] = Category::pluck('name','id');
        $data['book']  = Book::find($id);

        //set title for specify by the item type
        $data['title'] = 'Edit ' . ucwords( $data['book']->type );

        //load subview specifically for the item Type
        $data['subview'] = 'edit' . strtolower( $data['book']->type );
        return view('dashboard.library.edit', $data );
    }


    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required'
        ]);

        $data = $request->all();

        $data['admin_id'] = Auth::user()->id;
        $data['category'] = ( $data['type'] == 'book' ) ? json_encode($data['category']) : null;
        $data['category'] = json_encode($data['category']);

        $book = Book::find($id);

        if($request->file('cover_photo')) {
            if($book->cover_photo!=""){
                $upload_file="uploads/books/".$book->cover_photo;
            }
            $profile_image = $request->file('cover_photo');
            $upload = 'uploads/books';

            $extension = $profile_image->getClientOriginalExtension();
            $profile_image_name = md5(time()) . "." . $extension;
            $success = $profile_image->move($upload, $profile_image_name);

            $data['cover_photo'] = $profile_image_name;

        }

        if($request->file('e_book')) {
            if($book->e_book!=""){
                $upload_file="uploads/books/".$book->e_book;
                //unlink($upload_file);
            }
            $profile_image = $request->file('e_book');
            $upload = 'uploads/books';

            $extension = $profile_image->getClientOriginalExtension();
            $profile_image_name = time() . "." . $extension;
            $success = $profile_image->move($upload, $profile_image_name);

            $data['file'] = $profile_image_name;

        }


        $book->update($data);

        return redirect()->route('book.index')->with('update_success','Updated Successfully');
    }

    public function remove( Request $request, $id )
    {
        $item = Book::find( $id );

        //remove files
        if($item->cover_photo!=""){
            $upload_file="uploads/books/".$item->cover_photo;
            if( file_exists( $upload_file ) )
                unlink($upload_file);
        }
        if($item->file!=""){
            $upload_file="uploads/books/".$item->file;
            if( file_exists( $upload_file ) )
                unlink($upload_file);
        }

        //remove item
        if( $item->delete() ) {
            return redirect()->route('book.index')->with('delete_success','Book deleted successfully');
        } else {
            return redirect()->route('book.index')->with('delete_failed','Sorry! cannot delete this item.');
        }
    }


    public function destroy($id)
    {
        $book=Book::find($id);

        $type = $book->type;


        if($book->delete()){

            if($book->cover_photo!=""){
                $upload_file = "uploads/books/".$book->cover_photo;
                if( file_exists( $upload_file ))
                    unlink($upload_file);
            }
            if($book->file!=""){
                $upload_file="uploads/books/".$book->file;
                if( file_exists( $upload_file ))
                 unlink($upload_file);
            }

        }

        return redirect()->route('book.index', ['type' => $type])->with('delete_success','Book deleted successfully');
    }

    public function printqr( Request $request )
    {

        // dd( $request->id );
        //check request parameter has items ID
        if( empty( $request->id ) && count( $request->id ) )
            return redirect()->back()->with('success', 'No Items selected or Supplied.');

        //get items
        $data['title'] = 'Print QR Codes';
        $data['items'] = \App\Library::whereIn('id', $request->id )->get();

        //load view
        return view('dashboard.library.printqr', $data );
    }

}
