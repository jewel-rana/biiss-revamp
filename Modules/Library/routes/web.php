<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Modules\Library\App\Http\Controllers\AjaxController;
use Modules\Library\App\Http\Controllers\EResourceController;
use Modules\Library\App\Http\Controllers\FeatureController;
use Modules\Library\App\Http\Controllers\IssueController;
use Modules\Library\App\Http\Controllers\LibraryController;
use Modules\Library\App\Http\Controllers\MessageController;
use Modules\Library\App\Http\Controllers\ReturnController;

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

Route::group(['prefix' => 'e-resource'], function () {
    Route::get('/e-book', [EResourceController::class, 'eBook'])->name('e-book');
    Route::get('/e-book/{item}', [EResourceController::class, 'show'])->name('e-book.show');
    Route::get('/e-journal', [EResourceController::class, 'eJournal'])->name('e-journal');
    Route::get('/e-journal/{item}', [EResourceController::class, 'show'])->name('e-journal.show');
    Route::get('/e-document', [EResourceController::class, 'eDocument'])->name('e-document');
    Route::get('/e-document/{item}', [EResourceController::class, 'show'])->name('e-document.show');

    Route::group(['middleware' => ['auth:web']], function () {
        Route::get('/pdf/{library}', [EResourceController::class, 'pdfViewer'])->name('library.pdf');
        Route::get('/{type}/{library}', [EResourceController::class, 'eBookReader'])->name('library.reader');
    });
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:web']], function () {

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'library'], function () {
        //messaging routes group
        Route::group(['prefix' => 'message', 'middleware' => ['auth:web']], function () {
            Route::get('reply/{message}', 'Dashboard\MessageController@edit')->name('message.reply');
            Route::post('reply/{message}', 'Dashboard\MessageController@edit')->name('message.replied');
        });
        Route::resource('message', MessageController::class);

        Route::get('search', [BookController::class, 'search'])->name('book.search');
        Route::post('create-book', ['as' => 'book.store', 'uses' => 'BooksController@store']);

        Route::post('create-seminar', [BookController::class, 'createSeminar']);
        Route::post('create-journal', [BookController::class, 'createJournal']);
        Route::get('clone/{library}', [LibraryController::class, 'clone'])->name('library.clone');

        Route::post('print-qr', 'BookController@printqr')->name('library.print.qr');

            //search items
            Route::get('search', [BookController::class, 'index'])->name('library.search');

        //Stock
        Route::group(['prefix' => 'stock', 'middleware' => ['auth']], function () {
            Route::get('/', ['as' => 'dashboard.stock.index', 'uses' => 'Dashboard\StockController@index', 'middleware' => ['permission:book-list|book-create|book-edit|book-delete']]);
            Route::get('add/{id}', ['as' => 'book.search', 'uses' => 'Dashboard\StockController@search', 'middleware' => ['permission:book-list|book-create|book-edit|book-delete']]);
            Route::get('delete/{id}', ['as' => 'book.search', 'uses' => 'Dashboard\StockController@search', 'middleware' => ['permission:book-list|book-create|book-edit|book-delete']]);
        });

        //book ret
        Route::get('myform/ajax/{id}', array('as' => 'myform.ajax', 'uses' => 'Dashboard\ReturnController@myformAjax'));
        Route::get('myformQr/ajax/{id}', array('as' => 'myformQr.ajax', 'uses' => 'Dashboard\ReturnController@myformAjaxQr'));
        Route::get('suggestions', [LibraryController::class, 'suggestions'])->name('library.suggestions');
        Route::resource('return', ReturnController::class);
    });

    //Ajax Request
    Route::group(['prefix' => 'ajax'], function () {
        //search in the front
        Route::get('library/front/suggestions', [AjaxController::class, 'frontSuggestion']);
        Route::get('library/front/suggestions/{keyword}', [AjaxController::class, 'frontSuggestion']);
        Route::get('library/front/author-suggestions', [AjaxController::class, 'authorSuggestion']);
        Route::get('library/front/author-suggestions/{keyword}', [AjaxController::class, 'authorSuggestion']);
        Route::get('library/front/category-suggestions', [AjaxController::class, 'catSuggest'])->name('ajax.tags');
        Route::get('library/front/search', [AjaxController::class, 'search'])->name('datatable.frontend.search');

        //search in the backend
        Route::get('library/suggestions', [AjaxController::class, 'suggestion']);
        Route::get('library/suggestions/{keyword}', [AjaxController::class, 'suggestion']);
        Route::get('library/item/{id}', [AjaxController::class, 'singleitem']);
        Route::get('library/single/{id}', [AjaxController::class, 'single']);
        Route::get('member/suggestions', [AjaxController::class, 'memberSuggestion']);
        Route::get('member/single/{id}', [AjaxController::class, 'member_single']);
        Route::post('createIssue', [AjaxController::class, 'createIssue']);
        Route::post('extendIssue', [AjaxController::class, 'extendIssue']);
        Route::post('library/issue-return', [AjaxController::class, 'issueReturn'])->name('issue.ajax.return');
        Route::get('library/get-all-items', [AjaxController::class, 'getAllItems'])->name('ajax.datatable.items');
        Route::post('library/create', [AjaxController::class, 'create'])->name('dashboard.ajax.create');
        Route::post('library/update', [AjaxController::class, 'update'])->name('dashboard.ajax.update');
        Route::get('library/delete/{id}', [AjaxController::class, 'deleteItem'])->name('dashboard.ajax.delete');
        Route::post('library/lost', [AjaxController::class, 'lostItem'])->name('dashboard.ajax.lost.item');
        Route::post('library/add-copy', [AjaxController::class, 'addMoreCopy'])->name('dashboard.ajax.add.more.copy');
        Route::post('jq-upload', [AjaxController::class, 'jqupload'])->name('dashboard.ajax.jqupload');
        Route::post('author/delete', [AjaxController::class, 'deleteAuthor'])->name('dashboard.ajax.author.delete');
    });

    //library issue
    Route::group(['prefix' => 'issue'], function () {
        Route::get('extend/{issue}', [IssueController::class, 'extend'])->name('issue.extend');
        Route::post('return/{issue}', [IssueController::class, 'takeReturn'])->name('issue.return');

        //book issue
        Route::get('change-copy/ajax/{id}', [IssueController::class, 'myChangeCopyAjax'])->name('issue.copy.ajax');

        Route::get('get_data_by_qr_string/{string}', [IssueController::class, 'getDataByQrString'])->name('issue.get_data_by_qr_string');

        //issues expired list
        Route::get('expired', [IssueController::class, 'expiredIndex'])->name('issue.expired');
        // return of this week list
        Route::get('weekly-return', [IssueController::class, 'returnWeekIndex'])->name('issue.weekly-return');
    });
    Route::resource('issue', IssueController::class);

    //Featured
    Route::group(['prefix' => 'feature'], function () {
        Route::get('/add/{id}', [FeatureController::class, 'add'])->name('feature.add');
    });

    Route::resource('feature', FeatureController::class);
    Route::resource('library', LibraryController::class);
});

