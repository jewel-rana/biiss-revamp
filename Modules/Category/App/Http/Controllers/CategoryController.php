<?php

namespace Modules\Category\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Category\App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $items = Category::filter($request)->orderBy('id','DESC')->paginate(10);
        $title = 'All Categories';
        return view('category::index',compact('items', 'title'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        $title = 'Create new Category';
        return view('category::create', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'details' => 'required'

        ]);

        Category::create($request->all());
        return redirect()->route('category.index')->with('success','Category created successfully');
    }

    public function show(Category $category): View
    {
        $data['item'] = $category;
        $data['title'] = 'Category Details';
        return view('category::show',$data);
    }

    public function edit(Category $category): View
    {
        $data['item']  = $category;
        $data['title'] = 'Edit Category';
        return view('category::edit', $data);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());

        return redirect()->route('category.index')->with('success','Category updated successfully');
    }


    public function destroy($id)
    {
        Category::find($id)->delete();

        return redirect()->route('category.index')->with('success','Category deleted successfully');
    }
}
