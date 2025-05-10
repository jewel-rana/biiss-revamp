<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Book;
use Validator;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function search( Request $request )
    {

        $search = $request->input('search');
        $query = new Book;

        $query->where('title', 'like', '%'.$search.'%');
        $query->orWhere('author', 'like', '%'.$search.'%' );
        $query->orWhere('type', 'like', '%'.$search.'%' );

        $items = $query->paginate(12);

        return view('book.index',compact('items'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required',
            'category' => 'required',
            'copy' => 'required|numeric'
        ]);

        $book = $request->all();

        // dd( $book );

        $copy = $book['copy'];
        if(!isset($copy)){
            $copy = 1;
        }

        $qr = array();
        $qr_string = time();
        
        for ($x = 1; $x <= $copy; $x++) {
            $code = 'c-' . $x . '-' . $qr_string;
            array_push($qr, $code);
        }

        // $book['qr_string_unique'] = time();
        $book['qr_string'] = json_encode($qr);
        $book['qr_string_unique'] = (string) $qr_string;
        $book['admin_id'] = Auth::user()->id;
        $book['category'] = json_encode($book['category']);
        if(isset($book['taggles'])){
            $book['taggles'] = json_encode($book['taggles']);
        }


        if($request->file('cover_photo')) {
            $cover_photo = $request->file('cover_photo');
            $upload = 'uploads/books';

            $extension = $cover_photo->getClientOriginalExtension();
            $cover_photo_name = md5(time()) . "." . $extension;
            $success = $cover_photo->move($upload, $cover_photo_name);

            $book['cover_photo'] = $cover_photo_name;

        }

        if($request->file('e_book')) {
            $e_book = $request->file('e_book');
            $upload = 'uploads/books';

            $extension = $e_book->getClientOriginalExtension();
            $e_book_name = time() . "." . $extension;
            $success = $e_book->move($upload, $e_book_name);

            $book['file'] = $e_book_name;

        }

        // dd( $book ); exit;

        $RetData = Book::create($book);

        $returnData = [];

        if( $book['type'] == 'book'){
            $message = 'Book created successfully!';
        }

        if( $book['type'] == 'journal'){
            $message = 'Journal created successfully!';
        }

        if( $book['type'] == 'seminar'){
            $message = 'Seminar created successfully!';
        }

        $returnData =[
            'message'=> $message,
            'Qr_DD_PRINT'=>$RetData->qr_string,
        ];


        return redirect()->route('book.index', ['type' => 'book'])->with('success',$returnData);
    }


    public function storejournal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'copy' => 'required'
        ]);

        if( $validator->fails())
        {
            return redirect()->route('book.create', ['type' => 'journal'])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $book = $request->all();

        // dd( $book );

        $copy = $book['copy'];
        if(!isset($copy)){
            $copy = 1;
        }

        $qr = array();
        $qr_string = time();
        
        for ($x = 1; $x <= $copy; $x++) {
            $code = 'c-' . $x . '-' . $qr_string;
            array_push($qr, $code);
        }

        // $book['qr_string_unique'] = time();
        $book['qr_string'] = json_encode($qr);
        $book['qr_string_unique'] = (string) $qr_string;
        $book['admin_id'] = Auth::user()->id;
        $book['category'] = null;
        if(isset($book['taggles'])){
            $book['taggles'] = json_encode($book['taggles']);
        }


        if($request->file('cover_photo')) {
            $cover_photo = $request->file('cover_photo');
            $upload = 'uploads/books';

            $extension = $cover_photo->getClientOriginalExtension();
            $cover_photo_name = md5(time()) . "." . $extension;
            $success = $cover_photo->move($upload, $cover_photo_name);

            $book['cover_photo'] = $cover_photo_name;

        }

        if($request->file('e_book')) {
            $e_book = $request->file('e_book');
            $upload = 'uploads/books';

            $extension = $e_book->getClientOriginalExtension();
            $e_book_name = time() . "." . $extension;
            $success = $e_book->move($upload, $e_book_name);

            $book['file'] = $e_book_name;

        }



        $RetData = Book::create($book);

        $returnData = [];

        if( $book['type'] == 'book'){
            $message = 'Book created successfully!';
        }

        if( $book['type'] == 'journal'){
            $message = 'Journal created successfully!';
        }

        if( $book['type'] == 'seminar'){
            $message = 'Seminar created successfully!';
        }

        $returnData =[
            'message'=> $message,
            'Qr_DD_PRINT'=>$RetData->qr_string,
        ];


        return redirect()->route('book.index', ['type' => 'journal'])->with('success',$returnData);
    }


    public function storeseminar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'copy' => 'required'
        ]);

        if( $validator->fails())
        {
            return redirect()->route('book.create', ['type' => 'seminar'])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $book = $request->all();

        // dd( $book );

        $copy = $book['copy'];
        if(!isset($copy)){
            $copy = 1;
        }
        $qr = array();
        $qr_string = time();
        
        for ($x = 1; $x <= $copy; $x++) {
            $code = 'c-' . $x . '-' . $qr_string;
            array_push($qr, $code);
        }

        // $book['qr_string_unique'] = time();
        $book['qr_string'] = json_encode($qr);
        $book['qr_string_unique'] = (string) $qr_string;
        $book['admin_id'] = Auth::user()->id;
        $book['category'] = null;
        if( isset( $book['taggles'] ) ) {
            $book['taggles'] = json_encode( $book['taggles'] );
        }


        if($request->file('cover_photo')) {
            $cover_photo = $request->file('cover_photo');
            $upload = 'uploads/books';

            $extension = $cover_photo->getClientOriginalExtension();
            $cover_photo_name = md5(time()) . "." . $extension;
            $success = $cover_photo->move($upload, $cover_photo_name);

            $book['cover_photo'] = $cover_photo_name;

        }

        if($request->file('e_book')) {
            $e_book = $request->file('e_book');
            $upload = 'uploads/books';

            $extension = $e_book->getClientOriginalExtension();
            $e_book_name = time() . "." . $extension;
            $success = $e_book->move($upload, $e_book_name);

            $book['file'] = $e_book_name;

        }



        $RetData = Book::create($book);

        $returnData = [];

        if( $book['type'] == 'book'){
            $message = 'Book created successfully!';
        }

        if( $book['type'] == 'journal'){
            $message = 'Journal created successfully!';
        }

        if( $book['type'] == 'seminar'){
            $message = 'Seminar created successfully!';
        }

        $returnData =[
            'message'=> $message,
            'Qr_DD_PRINT'=>$RetData->qr_string,
        ];


        return redirect()->route('book.index', ['type' => 'seminar'])->with('success',$returnData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
