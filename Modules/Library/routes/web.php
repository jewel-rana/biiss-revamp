<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Modules\Library\App\Http\Controllers\LibraryController;

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

//        //messaging routes group
//        Route::group(['prefix' => 'message', 'middleware' => ['auth:web']], function () {
//            Route::get('/', 'Dashboard\MessageController@index')->name('dashboard.message.inbox');
//            Route::get('view/{message}', 'Dashboard\MessageController@show')->name('dashboard.message.view');
//            Route::get('compose', 'Dashboard\MessageController@create')->name('dashboard.message.compose');
//            Route::post('compose', 'Dashboard\MessageController@create')->name('dashboard.message.send');
//            Route::get('reply/{message}', 'Dashboard\MessageController@edit')->name('dashboard.message.reply');
//            Route::post('reply/{message}', 'Dashboard\MessageController@edit')->name('dashboard.message.replied');
//        });


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
//            Route::get('clone/{id}', ['as' =>  route('library.clone', [LibraryController::class, 'cloneJournal']]);
//            Route::get('remove/{id}', ['as' => 'book.destroy', [LibraryController::class, 'remove']]);
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
//        //library issue
//        Route::get('issue', ['as' => 'book_issue.index', 'uses' => 'Dashboard\IssueController@index', 'middleware' => ['permission:book_issue|book-issues-list|book-issues-create|book-issues-edit|book-issues-delete']]);
//        Route::get('issue/create', ['as' => 'book_issue.create', 'uses' => 'Dashboard\IssueController@create', 'middleware' => ['permission:book-issues-create']]);
//        Route::get('issue/create/{id}', ['as' => 'book_issue.create', 'uses' => 'Dashboard\IssueController@create', 'middleware' => ['permission:book-issues-create']]);
//        Route::post('issue/create', ['as' => 'book_issue.store', 'uses' => 'Dashboard\IssueController@store', 'middleware' => ['permission:book-issues-create']]);
//        Route::get('issue/view/{id}', ['as' => 'book_issue.show', 'uses' => 'Dashboard\IssueController@show']);
//        Route::get('issue/{id}/edit', ['as' => 'book_issue.edit', 'uses' => 'Dashboard\IssueController@edit', 'middleware' => ['permission:book-issues-edit']]);
//        Route::patch('issue/edit/{id}', ['as' => 'book_issue.update', 'uses' => 'Dashboard\IssueController@update', 'middleware' => ['permission:book-issues-edit']]);
//        Route::delete('issue/delete/{id}', ['as' => 'book_issue.destroy', 'uses' => 'Dashboard\IssueController@destroy', 'middleware' => ['permission:book-issues-delete']]);
//
//        Route::get('issue/extend/{id}', 'Dashboard\IssueController@extend')->name('dashboard.issue.extend');
//        Route::get('issue/return/{id}', 'Dashboard\IssueController@takereturn')->name('dashboard.issue.return');
//
//        //book issue
//        Route::get('changecopy/ajax/{id}', array('as' => 'mychangecopy.ajax', 'uses' => 'Dashboard\IssueController@mychangecopyAjax'));
//
//        Route::get('get_data_by_qr_string/ajax/{string}', array('as' => 'get_data_by_qr_string.ajax', 'uses' => 'Dashboard\IssueController@getDataByQrString'));
//
//        //issues expired list
//        Route::get('book_issues/expired', ['uses' => 'Dashboard\IssueController@expiredIndex', 'middleware' => ['permission:book_issue|book-issues-list|book-issues-create|book-issues-edit|book-issues-delete']]);
//        // return of this week list
//        Route::get('book_issues/return', ['uses' => 'Dashboard\ReturnController@returnWeekIndex', 'middleware' => ['permission:book_issue|book-issues-list|book-issues-create|book-issues-edit|book-issues-delete']]);
//
//        //book return
//        Route::group(['prefix' => 'return', 'middleware' => ['auth']], function () {
//            Route::get('/', ['as' => 'book_return.index', 'uses' => 'Dashboard\ReturnController@index', 'middleware' => ['permission:book_return|book-issues-list|book-issues-create|book-issues-edit|book-issues-delete']]);
//            Route::get('create', ['as' => 'book_return.create', 'uses' => 'Dashboard\ReturnController@create', 'middleware' => ['permission:book-issues-create']]);
//            Route::post('create', ['as' => 'book_return.store', 'uses' => 'Dashboard\ReturnController@store', 'middleware' => ['permission:book-issues-create']]);
//            Route::get('view/{id}', ['as' => 'book_return.show', 'uses' => 'Dashboard\ReturnController@show']);
//            Route::get('edit/{id}', ['as' => 'book_return.edit', 'uses' => 'Dashboard\ReturnController@edit', 'middleware' => ['permission:book-issues-edit']]);
//
//            Route::patch('edit/{id}', ['as' => 'book_return.update', 'uses' => 'Dashboard\ReturnController@update', 'middleware' => ['permission:book-issues-edit']]);
//            Route::delete('delete/{id}', ['as' => 'book_return.destroy', 'uses' => 'Dashboard\ReturnController@destroy', 'middleware' => ['permission:book-issues-delete']]);
//        });
//
//        //book featured
//        Route::group(['prefix' => 'feature', 'middleware' => ['auth']], function () {
//            Route::get('/', [FeatureController::class, 'index'])->name('dashboard.feature.index');
////            Route::get('/create', 'Dashboard\FeatureController@create')->name('dashboard.feature.create');
////            Route::get('/add/{id}', 'Dashboard\FeatureController@add')->name('dashboard.feature.add');
////            Route::patch('/edit/{id}', 'Dashboard\FeatureController@edit')->name('dashboard.feature.edit');
////            Route::delete('/delete/{id}', 'Dashboard\FeatureController@destroy')->name('dashboard.feature.update');
//        });
//
//        //book ret
//        Route::get('myform/ajax/{id}', array('as' => 'myform.ajax', 'uses' => 'Dashboard\ReturnController@myformAjax'));
//        Route::get('myformQr/ajax/{id}', array('as' => 'myformQr.ajax', 'uses' => 'Dashboard\ReturnController@myformAjaxQr'));
//
//        //banners
//        Route::get('banners', ['as' => 'banners.index', 'uses' => 'OptionController@index', 'middleware' => ['permission:banners|banner-list|banner-create|banner-edit|banner-delete']]);
//        Route::get('banners/create', ['as' => 'banners.create', 'uses' => 'OptionController@create', 'middleware' => ['permission:banner-create']]);
//        Route::post('banners/create', ['as' => 'banners.store', 'uses' => 'OptionController@store', 'middleware' => ['permission:banner-create']]);
//        Route::get('banners/{id}', ['as' => 'banners.show', 'uses' => 'BookController@show']);
//        Route::get('banners/{id}/edit', ['as' => 'banners.edit', 'uses' => 'OptionController@edit', 'middleware' => ['permission:book-edit']]);
//        Route::patch('banners/{id}', ['as' => 'banners.update', 'uses' => 'OptionController@update', 'middleware' => ['permission:book-edit']]);
//        Route::delete('banners/{id}', ['as' => 'banners.destroy', 'uses' => 'OptionController@destroy', 'middleware' => ['permission:book-delete']]);
    });

    Route::resource('library', LibraryController::class)->names('library');
});

