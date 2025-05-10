<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index( Request $request ) {

        $search=trim($request->input('search'));

        $query = \App\LibraryIssue::with(['item', 'member', 'stock'])->where('is_returned',0)->orderBy('id', 'desc');

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( $id = '' )
    {

        $data['item'] = ( $id ) ? \App\Library::find( $id ) : '';

        $data['type'] = ( $data['item'] ) ? $data['item']->type : '';
        $data['title'] = ( $data['item'] ) ? 'New ' . ucfirst( $data['item']->type ) . ' Issue' : 'New Issue';

        return view('dashboard.library.issue.create', $data );
    }

    public function takereturn( $itemId )
    {
        $copynum = isset( $_GET['copy'] ) ? $_GET['copy'] : '';

        //get issue info
        $issue = \App\LibraryIssue::where(['book_id' => $itemId, 'stock_id' => $copy])->get();

        if( !empty( $issue ) ) :
            return back();
        else :
            return back();
        endif;
    }

    public function extend( $id )
    {
        $data['issue'] = \App\LibraryIssue::with(['member', 'item'])->find( $id );
        $data['title'] = 'Extend validity of Issue';

        return view('dashboard.library.issue.extend', $data );
    }

    public function getDataByQrString( Request $request, $qr_string )
    {
        $bookinfo = \App\Library::where('qr_string_unique', $qr_string)->first();

        return json_encode($bookinfo);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
