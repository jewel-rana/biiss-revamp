<?php

namespace Modules\Library\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EResourceController extends Controller
{
    public function eBook(Request $request): View
    {
        $query = Library::with('authors')
            ->where('type', 'book')
            ->where('is_eresource', true);
        if (isset($_GET['letter_sort'])) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        else :
            $query->orderBy('title', 'ASC');
        endif;
        $books = $query->paginate(25)->withQueryString();
        return view('library::e-resource.e-book', compact('books'));
    }

    public function eJournal(Request $request): View
    {
        $query = Library::with('authors')
            ->where('type', 'journal')
            ->where('is_eresource', true);
        if (isset($_GET['letter_sort'])) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        else :
            $query->orderBy('title', 'ASC');
        endif;
        $books = $query->paginate(25)->withQueryString();
        return view('library::e-resource.e-book', compact('books'));
    }

    public function eDocument(Request $request): View
    {
        $query = Library::with('authors')
            ->where('type', 'document')
            ->where('is_eresource', true);
        if (isset($_GET['letter_sort'])) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        else :
            $query->orderBy('title', 'ASC');
        endif;
        $books = $query->paginate(25)->withQueryString();
        return view('library::e-resource.e-document', compact('books'));
    }

    public function show(Library $item): View
    {
        return view('library::e-resource.show', compact('item'));
    }
}
