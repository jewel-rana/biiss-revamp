<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BookExportController extends Controller
{
    public function import_book()
    {
    	return view('book.export.book');
    }
    
    public function import_book_upload( Request $request )
    {
    	$this->validate( $request, array(
    		'file' => 'required'
    	));

    	if( $request->hasFile('file'))
    	{
    		$extension = File::extension( $request->file->getClientOriginalName());

    		if( $extension == 'xlsx' || $extension == 'xls' || $extension == 'csv')
    		{
    			$path = $request->file->getRealPath();

    			$data = Excel::load($path, function( $reader ){})->get();

    			if( !empty( $data ) && $data->count() )
    			{
    				$insert = [];

    				foreach( $data as $key => $value ){
    					// 'user_id' => $value->user_id,
    				}

    				if( !empty( $insert ) )
    				{
    					$insertData = DB::table('books')->insert( $insert );

    					if( $insertData )
    					{
    						Session::flash('success', 'Your data has been successfully imported.');
    					} else 
    					{
    						Session::flash('error', 'Error importing data.');
    					}
    				}
    			}
    		}
    	}
    }
}
