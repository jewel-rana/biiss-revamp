<?php

namespace Modules\Season\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Season\App\Models\Season;

class SeasonController extends Controller
{

    public function index(Request $request): View
    {
        $items = Season::filter($request)->orderBy('id','DESC')->paginate(10);

        $title = 'All Seasons';
        return view('season::index',compact('items', 'title'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        $title = 'Create new season';
        return view('season::create', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:seasons,name'
        ]);

        Season::create($request->all());
        return redirect()->route('season.index')->with('success','Season created successfully');
    }

    public function show(Season $season): View
    {
        $data['item'] = $season;
        $data['title'] = 'season Details';
        return view('season::show', $data);
    }

    public function edit(Season $season): View
    {
        $data['item']  = $season;
        $data['title'] = 'Edit season';
        return view('season::edit',$data);
    }

    public function update(Request $request, Season $season)
    {
        $this->validate($request, [
            'name' => 'required|unique:seasons,name,' . $season->id
        ]);

        $season->update($request->all());

        return redirect()->route('season.index')->with('success','Season updated successfully');
    }

    public function destroy(Season $season)
    {
        $season->delete();
        return redirect()->route('season.index')->with('success','Season deleted successfully');
    }
}
