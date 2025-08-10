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
            ->where('has_e_resource', true);

        if ($request->filled('year')) {
            $query->where('publication_year', $request->input('year'));
        }

        if ($request->filled('subject')) {
            $query->whereHas('authors', function ($query) use ($request) {
                $query->where('auth_subject', 'LIKE', '%' . trim($request->input('subject')) . '%');
            });
        }

        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . trim($request->input('keyword')) . '%');
        }

        if ($request->filled('author')) {
            $query->whereHas('authors', function ($query) use ($request) {
                $query->where('author_name', 'LIKE', '%' . trim($request->input('author')) . '%');
            });
        }

        if ($request->filled('letter_sort')) {
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        } else {
            $query->orderBy('title', 'ASC');
        }

        $books = $query->paginate(25)->withQueryString();
        return view('library::e-resource.e-book', compact('books'));
    }

    public function eJournal(Request $request): View
    {
        $query = Library::with('authors')
            ->where('type', 'journal')
            ->where('has_e_resource', true);

        if ($request->filled('year')) {
            $query->where('publication_year', $request->input('year'));
        }

        if ($request->filled('subject')) {
            $query->whereHas('authors', function ($query) use ($request) {
                $query->where('auth_subject', 'LIKE', '%' . trim($request->input('subject')) . '%');
            });
        }

        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . trim($request->input('keyword')) . '%');
        }

        if ($request->filled('author')) {
            $query->whereHas('authors', function ($query) use ($request) {
                $query->where('author_name', 'LIKE', '%' . trim($request->input('author')) . '%');
            });
        }

        if (isset($_GET['letter_sort'])) :
            $letter = $_GET['letter_sort'];
            $query->where('title', 'LIKE', $letter . '%');
        else :
            $query->orderBy('title', 'ASC');
        endif;
        $books = $query->paginate(25)->withQueryString();
        return view('library::e-resource.e-journal', compact('books'));
    }

    public function eDocument(Request $request): View
    {
        $query = Library::with('authors')
            ->where('type', 'document')
            ->where('has_e_resource', true);

        if ($request->filled('year')) {
            $query->where('publication_year', $request->input('year'));
        }

        if ($request->filled('subject')) {
            $query->whereHas('authors', function ($query) use ($request) {
                $query->where('auth_subject', 'LIKE', '%' . trim($request->input('subject')) . '%');
            });
        }

        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . trim($request->input('keyword')) . '%');
        }

        if ($request->filled('author')) {
            $query->whereHas('authors', function ($query) use ($request) {
                $query->where('author_name', 'LIKE', '%' . trim($request->input('author')) . '%');
            });
        }

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

    public function eBookReader($type, Library $library): View
    {
        return view('library::e-resource.reader', compact('type', 'library'));
    }

    public function pdfViewer(Library $library): View
    {
        return view('library::e-resource.pdf', compact('library'));
    }
}
