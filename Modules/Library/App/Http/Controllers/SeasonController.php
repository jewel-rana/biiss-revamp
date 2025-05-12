<?php

namespace Modules\Library\App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{


    public function index(Request $request){

        $search=trim($request->input('search'));
        $items = Season::orderBy('id','DESC')->paginate(5);

        if(isset($search)){
            $items=Season::where('name','like','%'.$search.'%')->orderBy('id','DESC')->paginate(10);
        }
        $title = 'All Seasons';
        return view('dashboard.library.season.index',compact('items', 'title'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){
        $title = 'Create new season';
        return view('dashboard.library.season.create', compact('title'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:seasons,name'

        ]);

        $data = $request->all();

        Season::create($data);

        return redirect()->route('dashboard.season.index')->with('success','Season created successfully');
    }


    public function show($id){

        $data['item'] = Season::find($id);
        $data['title'] = 'season Details';
        return view('dashboard.library.season.show',$data);
    }

    public function edit($id)
    {

        $data['item']  = Season::find($id);
        $data['title'] = 'Edit season';
        return view('dashboard.library.season.edit',$data);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:seasons,name,' . $id
        ]);

        $data = $request->all();

        Season::find($id)->update($data);

        return redirect()->route('dashboard.season.index')->with('success','Season updated successfully');
    }


    public function destroy($id)
    {
        Season::find($id)->delete();

        return redirect()->route('dashboard.season.index')->with('success','Season deleted successfully');
    }

}
