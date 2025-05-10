<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Options;

class OptionController extends Controller
{
    public function index(Request $request){

        $items = Options::where('name','banner')->orderBy('id','DESC')->paginate(5);

        $title = 'Banners';
        return view('banners.index',compact('items', 'title'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(){
        $title = 'Add new Banner';
        return view('banners.create', compact('title'));

    }

    public function store(Request $request){
        /*$this->validate($request, [
            'title' => 'required',
            'subject' => 'required',

        ]);*/


        $data = $request->all();



        $data['name'] = 'banner';
        $data['is_active'] = 1;


        if($request->file('banner_image')) {
            $cover_photo = $request->file('banner_image');
            $upload = 'uploads/banners';

            $extension = $cover_photo->getClientOriginalExtension();
            $cover_photo_name = md5(time()) . "." . $extension;
            $success = $cover_photo->move($upload, $cover_photo_name);

            $data['value'] = $cover_photo_name;

        }



        Options::create($data);

        return redirect()->route('banners.index')->with('success','Banner Created!!!');
    }

    public function destroy($id)
    {
        Options::find($id)->delete();

        return redirect()->route('banners.index')->with('success','Banner deleted successfully');
    }




}
