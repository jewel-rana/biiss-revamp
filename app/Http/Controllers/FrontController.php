<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Library;
use App\Models\Options;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(Request $request): View
    {
        $data['books'] = Feature::with('item')->where('type', 'new_book')->orderBy('created_at', 'DESC')->take(15)->get();

        $data['featuredBooks'] = Feature::with('item')->where('type', 'book')->orderBy('created_at', 'desc')->take(15)->get();

        $data['featuredJournals'] = Feature::with('item')->where('type', 'journal')->orderBy('created_at', 'desc')->take(15)->get();

        $data['featuredSeminars'] = Feature::with('item')->where('type', 'seminar')->orderBy('created_at', 'desc')->take(15)->get();

        $data['featuredMagazins'] = Feature::with('item')->where('type', 'magazine')->orderBy('created_at', 'desc')->take(15)->get();

        $data['featuredDocuments'] = Feature::with('item')->where('type', 'document')->orderBy('created_at', 'desc')->take(15)->get();

        $data['banners'] = Options::where('name', 'banner')->orderBy('id', 'DESC')->take(5)->get();

        return view('index', $data);
    }

    public function allBooks(): View
    {
        $query = Library::with('authors')->where('type', 'book');
        if (isset($_GET['letter_sort'])) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        else :
            $query->orderBy('title', 'ASC');
        endif;
        $data['books'] = $query->paginate(25)->withQueryString();

        return view('frontend.all-books', $data);
    }

    public function allJournals(): View
    {
        $query = Library::with('authors')->where('type', 'journal');
        if (isset($_GET['letter_sort'])) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        else :
            $query->orderBy('title', 'ASC');
        endif;
        $data['books'] = $query->paginate(25);

        return view('frontend.all-journals', $data);
    }

    public function allMagazines(): View
    {
        $query = Library::with('authors')->where('type', 'magazine');
        if (isset($_GET['letter_sort'])) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        else :
            $query->orderBy('title', 'ASC');
        endif;
        $data['books'] = $query->paginate(25);

        return view('frontend.all-magazines', $data);
    }

    public function allDocuments(): View
    {
        $query = Library::with('authors')->where('type', 'document');
        if (isset($_GET['letter_sort'])) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        else :
            $query->orderBy('title', 'ASC');
        endif;
        $data['books'] = $query->paginate(25);

        return view('frontend.all-documents', $data);
    }

    public function allSeminars(): View
    {
        $query = Library::with('authors')->where('type', 'seminar');
        if (isset($_GET['letter_sort'])) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        else :
            $query->orderBy('title', 'ASC');
        endif;
        $data['books'] = $query->paginate(25);

        return view('frontend.all-seminars', $data);
    }

    public function search(Request $request): View
    {
        $query = DB::table('libraries');
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->select('libraries.*')
                ->orWhere('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('article', 'LIKE', '%' . $keyword . '%');
        }

        if ($request->filled('author')) {
            $author = trim($request->author);
            $query->select('libraries.*')
                ->join('library_authors', 'libraries.id', '=', 'library_authors.item_id')
                ->where('library_authors.author_name', 'LIKE', '%' . $author . '%')
                ->distinct();
        }

        $data['items'] = $query->paginate(12);
        return view('frontend.search', $data);
    }

    public function newBooks(Request $request)
    {

        $data['books'] = Feature::with(['item'])->where('type', 'new_book')->orderBy('created_at', 'DESC')->paginate(16);

        $data['banners'] = Options::where('name', 'banner')->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.new-books', $data)->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function topBooks(Request $request)
    {

        $data['books'] = Feature::with(['item'])->where('type', 'book')->orderBy('id', 'DESC')->paginate(12);

        $data['banners'] = Options::where('name', 'banner')->orderBy('id', 'DESC')->limit(3)->get();


        return view('frontend.top-books', $data)->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function topJournals(Request $request)
    {

        $data['journals'] = Feature::with(['item'])->where('type', 'journal')->orderBy('id', 'DESC')->paginate(12);

        $data['banners'] = Options::where('name', 'banner')->orderBy('id', 'DESC')->limit(3)->get();


        return view('frontend.top-journals', $data)->with('i', ($request->input('page', 1) - 1) * 10);
    }


    public function topSeminars(Request $request)
    {
        $data['items'] = Feature::with('item')->where('type', 'seminar')->orderBy('id', 'DESC')->paginate(12);
        $data['banners'] = Options::where('name', 'banner')->orderBy('id', 'DESC')->limit(3)->get();


        return view('frontend.top-seminars', $data)->with('i', ($request->input('page', 1) - 1) * 10);
    }


    public function contact()
    {
        $data['banners'] = Options::where('name', 'banner')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.contact', $data);
    }

    public function show($id)
    {
        $data['book'] = Library::findOrFail($id);

        if (!$data['book'])
            return redirect()->back()->with('error', 'Item not found.');

        $data['title'] = $data['book']->title;
        $data['banners'] = Options::where('name', 'banner')->orderBy('id', 'DESC')->limit(3)->get();
        // return $data;
        return view('frontend.single', $data);
    }


}
