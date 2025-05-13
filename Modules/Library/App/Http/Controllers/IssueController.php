<?php

namespace Modules\Library\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\LibraryIssue;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index( Request $request ): View
    {
        $title = ucwords($request->get('type', 'All'), '_') . ' Issues';
        $issues = LibraryIssue::with(['item', 'member', 'stock'])->filter($request)->orderBy('id', 'desc')->get();
        return view('library::library.issue.index', compact('issues', 'title'));
    }

    public function create( $id = '' ): View
    {
        $data['item'] = ( $id ) ? Library::find( $id ) : '';
        $data['type'] = ( $data['item'] ) ? $data['item']->type : '';
        $data['title'] = ( $data['item'] ) ? 'New ' . ucfirst( $data['item']->type ) . ' Issue' : 'New Issue';
        return view('library::library.issue.create', $data );
    }

    public function takereturn( $itemId )
    {
        $copynum = isset( $_GET['copy'] ) ? $_GET['copy'] : '';

        //get issue info
        $issue = LibraryIssue::where(['book_id' => $itemId, 'stock_id' => $copy])->get();

        if( !empty( $issue ) ) :
            return back();
        else :
            return back();
        endif;
    }

    public function extend( $id ): View
    {
        $data['issue'] = LibraryIssue::with(['member', 'item'])->find( $id );
        $data['title'] = 'Extend validity of Issue';

        return view('library::library.issue.extend', $data );
    }

    public function getDataByQrString( Request $request, $qr_string )
    {
        $bookinfo = Library::where('qr_string_unique', $qr_string)->first();

        return json_encode($bookinfo);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
