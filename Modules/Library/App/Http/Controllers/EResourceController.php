<?php

namespace Modules\Library\App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EResourceController extends Controller
{
    public function eBook(Request $request)
    {
        $query = Library::query()
            ->with('authors')
            ->where('type', 'book')
            ->where('has_e_resource', true);

        if ($request->filled('year')) {
            $query->where('publication_year', $request->input('year'));
        }

        if ($request->filled('subject')) {
            $subject = trim($request->input('subject'));
            $query->whereHas('authors', function ($q) use ($subject) {
                $q->where('auth_subject', 'LIKE', '%' . CommonHelper::likeEscape($subject) . '%');
            });
        }

        if ($request->filled('keyword')) {
            // Normalize spaces and require all words to appear somewhere in the title
            $query->where('title', 'LIKE', '%' . stripcslashes($request->input('keyword')) . '%');
        }

        if ($request->filled('author')) {
            $author = trim($request->input('author'));
            $query->whereHas('authors', function ($q) use ($author) {
                $q->where('author_name', 'LIKE', '%' . CommonHelper::likeEscape($author) . '%');
            });
        }

        if ((!$request->filled('author') && !$request->filled('subject') && !$request->filled('keyword') && !$request->filled('year')) && $request->filled('letter_sort')) {
            if ($request->filled('letter_sort')) {
                $letter = $request->input('letter_sort'); // no $_GET
                if ($letter !== null && $letter !== '') {
                    $query->where('title', 'LIKE', CommonHelper::likeEscape($letter) . '%');
                } else {
                    $query->orderBy('title', 'ASC');
                }
            } else {
                $query->orderBy('title', 'ASC');
            }
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
                $query->where('auth_subject', 'LIKE', '%' . CommonHelper::likeEscape(trim($request->input('subject'))) . '%');
            });
        }

        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . CommonHelper::likeEscape(trim($request->input('keyword'))) . '%');
        }

        if ($request->filled('author')) {
            $query->whereHas('authors', function ($query) use ($request) {
                $query->where('author_name', 'LIKE', '%' . CommonHelper::likeEscape(trim($request->input('author'))) . '%');
            });
        }

        if ((!$request->filled('author') && !$request->filled('subject') && !$request->filled('keyword') && !$request->filled('year')) && $request->filled('letter_sort')) {
            if ($request->filled('letter_sort')) {
                $letter = $request->input('letter_sort'); // no $_GET
                if ($letter !== null && $letter !== '') {
                    $query->where('title', 'LIKE', CommonHelper::likeEscape($letter) . '%');
                } else {
                    $query->orderBy('title', 'ASC');
                }
            } else {
                $query->orderBy('title', 'ASC');
            }
        } else {
            $query->orderBy('title', 'ASC');
        }
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
                $query->where('auth_subject', 'LIKE', '%' . CommonHelper::likeEscape(trim($request->input('subject'))) . '%');
            });
        }

        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . CommonHelper::likeEscape(trim($request->input('keyword'))) . '%');
        }

        if ($request->filled('author')) {
            $query->whereHas('authors', function ($query) use ($request) {
                $query->where('author_name', 'LIKE', '%' . CommonHelper::likeEscape(trim($request->input('author'))) . '%');
            });
        }

        if ((!$request->filled('author') && !$request->filled('subject') && !$request->filled('keyword') && !$request->filled('year')) && $request->filled('letter_sort')) {
            if ($request->filled('letter_sort')) {
                $letter = $request->input('letter_sort'); // no $_GET
                if ($letter !== null && $letter !== '') {
                    $query->where('title', 'LIKE', CommonHelper::likeEscape($letter) . '%');
                } else {
                    $query->orderBy('title', 'ASC');
                }
            } else {
                $query->orderBy('title', 'ASC');
            }
        } else {
            $query->orderBy('title', 'ASC');
        }
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
