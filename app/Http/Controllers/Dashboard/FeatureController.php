<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = ( isset( $_GET['type'] ) ) ? $_GET['type'] : 'book';
        $data['items'] = \App\Feature::with(['item'])->where('type', $type)->get();
        $data['pageTitle'] = 'Featured Top ' . ucwords( str_replace( '_', ' ', $type ) ) . 's';
        $data['type'] = $type;
        return view('dashboard.feature.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request )
    {
        $data['type'] = ( $request->type ) ? $request->type : 'book';
        $data['search'] = ( $request->search ) ? $request->search : '';

        //get few list from the library items by type
        $query = \App\Library::with('featured')->where('title', '!=', '');

        //if user provide type then use this condition
        if( isset( $_GET['type'] ) && $_GET['type'] != '' )
            $type = ($data['type'] == 'new_book' ) ? 'book' : $data['type'];
            $query->where( 'type', $type );

        //if title parameter supplied then run this condition
        $search = (isset( $_GET['search'] ) ) ? trim($_GET['search']) : '';
        if( isset( $_GET['search'] ) && !empty( $_GET['search'] ) ) :
            $query->where('title', 'LIKE', "%{$search}%");
            // $query->where('author', 'LIKE', "%{$search}%");
        endif;

        $data['items'] = $query->paginate(10);
        $data['title'] = 'Add new featured ' . ucfirst( $data['type'] );
        return view('dashboard.feature.create', $data );
    }

    public function add( $id )
    {
        $item = \App\Library::find( $id );

        $feature = new \App\Feature;
        $feature->book_id = $item->id;
        $feature->type = $type = ( isset( $_GET['type'] ) && $_GET['type'] != '' ) ? $_GET['type'] : $item->type;
        $feature->save();

        return redirect()->back()->with('success', 'Featured Item has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title'] = '';
        return view('dashboard.feature.show', $data );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id )
    {
        $feature = \App\Feature::find($id);

        $feature->delete();

        if($request->ajax()) :
            echo json_encode(array('success' => true ) );
        else :
            return redirect()->route('dashboard.feature.index')->with('success','Featured item has been deleted successfully.');
        endif;
    }
}
