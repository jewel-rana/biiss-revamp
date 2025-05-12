<?php

namespace Modules\Library\App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Library;
use App\Models\Season;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'book');
        $data['pageTitle'] = ucwords( $type ) . 's';
        $data['type'] = $type;
        $data['seasons'] = Season::pluck('name', 'name');
        return view('dashboard.library.index_' . strtolower( $type ), $data );
    }

    public function create( Request $request )
    {
        $data['type'] = ( $request->type ) ? $request->type : 'book';
        $data['search'] = ( $request->search ) ? $request->search : '';

        //get few list from the library items by type
        $query = Library::where('title', '!=', '');

        //if user provide type then use this condition
        if( isset( $_GET['type'] ) && $_GET['type'] != '' )
            $query->where( 'type', $data['type'] );

        //if title parameter supplied then run this condition
        $search = (isset( $_GET['search'] ) ) ? trim($_GET['search']) : '';
        if( isset( $_GET['search'] ) && !empty( $_GET['search'] ) ) :
            $query->where('title', 'LIKE', "%{$search}%");
            // $query->where('author', 'LIKE', "%{$search}%");
        endif;

        $data['items'] = $query->paginate(10);

        $data['seasons'] = Season::pluck('name', 'name');
        $data['title'] = 'Add new ' . ucfirst( $data['type'] );
        return view('dashboard.library.new', $data );
    }

    public function store(Request $request)
    {
        dd( $request );
    }

    public function add( $id )
    {
        $item = Library::find( $id );

        $feature = new Feature;
        $feature->book_id = $item->id;
        $feature->type = $item->type;
        $feature->save();

        return redirect()->back()->with('success', 'Featured Item has been added.');
    }

    public function show($id)
    {
        //retrive library item
        $data['item'] = Library::findOrFail( $id );

        //check library items found or not
        if( !$data['item'] )
            return redirect()->back()->with('success', 'No items found');

        //load data and view
        $data['type'] = strtolower( $data['item']->type );
        $data['title'] = ucfirst( $data['item']->type ) . ' - ' . $data['item']->title . ' (' . $data['item']->publication_year . ')';
        return view('dashboard.library.single_' . strtolower($data['item']->type), $data );
    }

    public function edit($id)
    {
        //retrieve item
         $data['library'] = Library::findOrFail( $id );

        //check library items found or not
        if( !$data['library'] )
            return redirect()->back()->with('success', 'No items found');
        //load view
        $data['title'] = 'Edit ' . $data['library']->type;
        $data['type'] = strtolower( $data['library']->type );
        $data['seasons'] = Season::pluck('name', 'name');

        $data['subview'] = 'edit_' . strtolower( $data['type'] );
        return view('dashboard.library.edit', $data );
    }

    public function cloneJournal($id)
    {
        //retrieve item
        $data['library'] = Library::findOrFail( $id );

        //check library items found or not
        if( !$data['library'] )
            return redirect()->back()->with('success', 'No items found');

        //load view
        $data['title'] = 'Clone ' . $data['library']->type;
        $data['type'] = strtolower( $data['library']->type );
        $data['seasons'] = Season::pluck('name', 'name');

        $data['subview'] = 'clone_' . $data['type'];
        return view('dashboard.library.clone', $data );
    }

    public function destroy(Request $request, $id )
    {
        $feature = Feature::find($id);
        if( $feature )
            $feature->delete();

        $item = Library::findOrFail( $id );

        if( !$item ) :
            if( $request->ajax() ){
                return response()->json(['success' => false]);
            } else {
                return redirect()->back()->with('errors','Sorry! cannot delete items.');
            }
        endif;

        $ok = $item->delete();

        if( $ok ) :
            if( $request->ajax() ){
                return response()->json(['success' => true]);
            }else {
                return redirect()->back()->with('success','Item has been deleted successfully.');
            }
        else :
            if( $request->ajax() ){
                return response()->json(['success' => false]);
            }else {
                return redirect()->back()->with('errors','Sorry! cannot delete items.');
            }
        endif;
    }

    public function remove( Request $request, $id )
    {
        $item = Library::findOrFail( $id );

        //remove item
        if( $item->delete() ) {
            return redirect()->route('dashboard.library.index')->with('delete_success','Book deleted successfully');
        } else {
            return redirect()->route('dashboard.library.index')->with('delete_failed','Sorry! cannot delete this item.');
        }
    }
}
