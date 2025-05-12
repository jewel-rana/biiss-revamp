<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/search', [FrontController::class, 'search'])->name('front.search');
Route::get('/new-books', [FrontController::class, 'newBooks'])->name('front.newBooks');
Route::get('/top-books', [FrontController::class, 'topBooks'])->name('front.topBooks');
Route::get('/all-books', [FrontController::class, 'allBooks'])->name('front.allBooks');
Route::get('/journals', [FrontController::class, 'allJournals'])->name('front.journals');
Route::get('/magazines', [FrontController::class, 'allMagazines'])->name('front.magazines');
Route::get('/documents', [FrontController::class, 'allDocuments'])->name('front.documents');
Route::get('/seminars', [FrontController::class, 'allSeminars'])->name('front.seminars');
Route::get('/top-journals', [FrontController::class, 'topJournals']);
Route::get('/import-book', [BookController::class, 'import_book'])->name('book.import');
Route::post('/import-book', [BookController::class, 'import_book_upload'])->name('book.import.upload');

//top seminar router
Route::get('/top-seminars', [FrontController::class, 'topSeminars']);
Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');
Route::get('/single/{id}',[FrontController::class, 'show'])->name('single.show');
//Route::resource('print', 'CartController');
//Route::delete('emptyPrint', 'CartController@emptyCart');
//Route::post('switchToWishlist/{id}', 'CartController@switchToWishlist');



//Ajax Request
Route::group(['prefix' => 'ajax'], function()
{
    //search in the front
    Route::get('library/front/suggestions', [AjaxController::class, 'frontsuggestion']);
    Route::get('library/front/suggestions/{keyword}', [AjaxController::class, 'frontsuggestion']);
    Route::get('library/front/authorsuggestions', [AjaxController::class, 'authorsuggestion']);
    Route::get('library/front/authorsuggestions/{keyword}', [AjaxController::class, 'authorsuggestion']);
    Route::get('library/front/categorysuggestions', [AjaxController::class, 'catSuggest'])->name('ajax.tags');
    Route::get('library/front/categorysuggestions/{keyword}', [AjaxController::class, 'catSuggest'])->name('ajax.tags');
    Route::get('library/front/search', [AjaxController::class, 'search'])->name('datatable.frontend.search');

    //search in the backend
    Route::get('library/suggestions', [AjaxController::class, 'suggestion']);
    Route::get('library/suggestions/{keyword}', [AjaxController::class, 'suggestion']);
    Route::get('library/item/{id}', [AjaxController::class, 'singleitem']);
    Route::get('library/single/{id}', [AjaxController::class, 'single']);
    Route::get('member/suggestions', [AjaxController::class, 'member_suggestion']);
    Route::get('member/suggestions/{keyword}', [AjaxController::class, 'member_suggestion']);
    Route::get('member/single/{id}', [AjaxController::class, 'member_single']);
    Route::post('createIssue', [AjaxController::class, 'createIssue']);
    Route::post('extendIssue', [AjaxController::class, 'extendIssue']);
    Route::post('issueReturn', [AjaxController::class, 'issueReturn']);
    Route::get('get-all-items', [AjaxController::class, 'getAllItems'])->name('ajax.datatable.items');
    Route::post('dashboard/library/create', [AjaxController::class, 'create'])->name('dashboard.ajax.create');
    Route::post('dashboard/library/update', [AjaxController::class, 'update'])->name('dashboard.ajax.update');
    Route::get('dashboard/library/delete/{id}', [AjaxController::class, 'deleteItem'])->name('dashboard.ajax.delete');
    Route::post('dashboard/library/lost', [AjaxController::class, 'lostItem'])->name('dashboard.ajax.lost.item');
    Route::post('dashboard/library/add-copy', [AjaxController::class, 'addMoreCopy'])->name('dashboard.ajax.add.more.copy');
    Route::post('dashboard/jqupload', [AjaxController::class, 'jqupload'])->name('dashboard.ajax.jqupload');
    Route::post('dashboard/author/delete', [AjaxController::class, 'deleteAuthor'])->name('dashboard.ajax.author.delete');
});


