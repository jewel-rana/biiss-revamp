<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Modules\Library\App\Http\Controllers\AjaxController;
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

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:web']], function () {

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'library'], function () {
//
//        Route::group(['prefix' => 'profile', 'middleware' => ['auth:web']], function () {
//            Route::get('/', 'UserController@profile')->name('dashboard.user.profile');
//            Route::get('/change-password', 'UserController@change_password')->name('dashboard.user.password');
//            Route::post('/change-password', 'UserController@passwordupdate')->name('dashboard.user.password.update');
//        });

        //messaging routes group
        Route::group(['prefix' => 'message', 'middleware' => ['auth:web']], function () {
            Route::get('reply/{message}', 'Dashboard\MessageController@edit')->name('message.reply');
            Route::post('reply/{message}', 'Dashboard\MessageController@edit')->name('message.replied');
        });
        Route::resource('message', MessageController::class);


        //Library
//        Route::group(['middleware' => ['auth:web']], function () {
//
//            Route::get('/', [LibraryController::class, 'index'])->name('library.index');
//            Route::get('search', ['as' => 'book.search', 'uses' => 'BooksController@search']);
//            Route::get('create', ['as' => 'book.create', 'uses' => 'BookController@create']);
//            // Route::get('create',['as'=>'book.create','uses'=>'BookController@create','middleware' => ['permission:book-create']]);
//            Route::post('createbook', ['as' => 'book.store', 'uses' => 'BooksController@store']);
//
//            Route::post('createseminar', ['as' => 'seminar.store', 'uses' => 'BooksController@storeseminar']);
//            Route::post('createjournal', ['as' => 'journal.store', 'uses' => 'BooksController@storejournal']);
//            Route::get('item/{id}', [LibraryController::class, 'show'])->name('library.view');
//            Route::get('/edit/{id}', ['as' =>  route('library.edit', [LibraryController::class, 'edit']]);
//            Route::patch('/edit/{id}', ['as' =>  route('library.update', [LibraryController::class, 'update']]);
//            Route::delete('delete/{id}', ['as' =>  route('library.delete', [LibraryController::class, 'destroy']]);
            Route::get('clone/{library}', [LibraryController::class, 'clone'])->name('library.clone');
//
        Route::post('print-qr', 'BookController@printqr')->name('library.print.qr');
//
//            //search items
//            Route::get('search', 'BookController@index')->name('library.search');
//
//            Route::get('/new', [LibraryController::class, 'create'])->name('library.create');
//            Route::post('/new', [LibraryController::class, 'store'])->name('library.store');
//

//
//        //Stock
//        Route::group(['prefix' => 'stock', 'middleware' => ['auth']], function () {
//            Route::get('/', ['as' => 'dashboard.stock.index', 'uses' => 'Dashboard\StockController@index', 'middleware' => ['permission:book-list|book-create|book-edit|book-delete']]);
//            Route::get('add/{id}', ['as' => 'book.search', 'uses' => 'Dashboard\StockController@search', 'middleware' => ['permission:book-list|book-create|book-edit|book-delete']]);
//            Route::get('delete/{id}', ['as' => 'book.search', 'uses' => 'Dashboard\StockController@search', 'middleware' => ['permission:book-list|book-create|book-edit|book-delete']]);
//        });
//

        //book return
        Route::resource('return', ReturnController::class);
//
//
//        //book ret
//        Route::get('myform/ajax/{id}', array('as' => 'myform.ajax', 'uses' => 'Dashboard\ReturnController@myformAjax'));
//        Route::get('myformQr/ajax/{id}', array('as' => 'myformQr.ajax', 'uses' => 'Dashboard\ReturnController@myformAjaxQr'));
//
    });

    //Ajax Request
    Route::group(['prefix' => 'ajax'], function()
    {
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
        Route::get('member/suggestions', [AjaxController::class, 'member_suggestion']);
        Route::get('member/suggestions/{keyword}', [AjaxController::class, 'member_suggestion']);
        Route::get('member/single/{id}', [AjaxController::class, 'member_single']);
        Route::post('createIssue', [AjaxController::class, 'createIssue']);
        Route::post('extendIssue', [AjaxController::class, 'extendIssue']);
        Route::post('issue-return', [AjaxController::class, 'issueReturn']);
        Route::get('get-all-items', [AjaxController::class, 'getAllItems'])->name('ajax.datatable.items');
        Route::post('dashboard/library/create', [AjaxController::class, 'create'])->name('dashboard.ajax.create');
        Route::post('dashboard/library/update', [AjaxController::class, 'update'])->name('dashboard.ajax.update');
        Route::get('dashboard/library/delete/{id}', [AjaxController::class, 'deleteItem'])->name('dashboard.ajax.delete');
        Route::post('dashboard/library/lost', [AjaxController::class, 'lostItem'])->name('dashboard.ajax.lost.item');
        Route::post('dashboard/library/add-copy', [AjaxController::class, 'addMoreCopy'])->name('dashboard.ajax.add.more.copy');
        Route::post('dashboard/jq-upload', [AjaxController::class, 'jqupload'])->name('dashboard.ajax.jqupload');
        Route::post('dashboard/author/delete', [AjaxController::class, 'deleteAuthor'])->name('dashboard.ajax.author.delete');
    });

    //library issue
    Route::group(['prefix' => 'issue'], function () {
        Route::get('issue/extend/{id}', [IssueController::class, 'extend'])->name('issue.extend');
        Route::get('issue/return/{id}', [IssueController::class, 'takeReturn'])->name('issue.return');

        //book issue
        Route::get('change-copy/ajax/{id}', [IssueController::class, 'myChangeCopyAjax'])->name('issue.copy.ajax');

        Route::get('get_data_by_qr_string/ajax/{string}', [IssueController::class, 'getDataByQrString'])->name('issue.get_data_by_qr_string');

        //issues expired list
        Route::get('issue/expired', [IssueController::class, 'expiredIndex'])->name('issue.expired');
        // return of this week list
        Route::get('issue/weekly-return', [IssueController::class, 'returnWeekIndex'])->name('issue.return');
    });
    Route::resource('issue', IssueController::class);

    //Featured
    Route::group(['prefix' => 'feature'], function () {
        Route::get('/add/{id}', 'Dashboard\FeatureController@add')->name('feature.add');
    });

    Route::resource('feature', FeatureController::class);
    Route::resource('library', LibraryController::class)->names('library');
});

