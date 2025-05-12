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
use App\Http\Controllers\Dashboard\LibraryController;
use App\Http\Controllers\HomeController;
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



Route::group(['prefix' => 'dashboard','middleware' => ['auth:web']], function() {

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
//
//    Route::get('member',['as'=>'users.index','uses'=>'UserController@index']);
//
//    Route::get('member/create',['as'=>'users.create','uses'=>'UserController@create']);
//
//    Route::post('member/create',['as'=>'users.store','uses'=>'UserController@store']);
//
//    Route::get('member/profile/{id}',['as'=>'users.show','uses'=>'UserController@show']);
//
//    Route::get('member/{id}/edit',['as'=>'users.edit','uses'=>'UserController@edit']);
//
//    Route::patch('member/{id}',['as'=>'users.update','uses'=>'UserController@update']);
//
//    Route::delete('member/{id}',['as'=>'users.destroy','uses'=>'UserController@destroy']);
//
//    Route::group(['prefix' => 'profile', 'middleware' => ['auth:web']], function()
//    {
//        Route::get('/', 'UserController@profile')->name('dashboard.user.profile');
//        Route::get('/change-password', 'UserController@change_password')->name('dashboard.user.password');
//        Route::post('/change-password', 'UserController@passwordupdate')->name('dashboard.user.password.update');
//    });
//
//    //messaging routes group
//    Route::group(['prefix' => 'message', 'middleware' => ['auth:web']], function()
//    {
//        Route::get('/', 'Dashboard\MessageController@index')->name('dashboard.message.inbox');
//        Route::get('view/{message}', 'Dashboard\MessageController@show')->name('dashboard.message.view');
//        Route::get('compose', 'Dashboard\MessageController@create')->name('dashboard.message.compose');
//        Route::post('compose', 'Dashboard\MessageController@create')->name('dashboard.message.send');
//        Route::get('reply/{message}', 'Dashboard\MessageController@edit')->name('dashboard.message.reply');
//        Route::post('reply/{message}', 'Dashboard\MessageController@edit')->name('dashboard.message.replied');
//    });
//
//
//    //member
//    Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);
//    Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create']);
//    Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
//    Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
//    Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit']);
//    Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update']);
//    Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy']);
//
//    //category
//    Route::get('category',['as'=>'category.index','uses'=>'CategoryController@index']);
//    Route::get('category/create',['as'=>'category.create','uses'=>'CategoryController@create']);
//    Route::post('category/create',['as'=>'category.store','uses'=>'CategoryController@store']);
//    Route::get('category/view/{id}',['as'=>'category.show','uses'=>'CategoryController@show']);
//    Route::get('category/{id}/edit',['as'=>'category.edit','uses'=>'CategoryController@edit']);
//    Route::patch('category/{id}',['as'=>'category.update','uses'=>'CategoryController@update']);
//    Route::delete('category/{id}',['as'=>'category.destroy','uses'=>'CategoryController@destroy']);
//
//    //Library
//    Route::group(['prefix' => 'library', 'middleware' => ['auth:web']], function()
//    {
//
//        Route::get('/', [LibraryController::class,  'index'])->name('dashboard.library.index');
//        Route::get('search',['as'=>'book.search','uses'=>'BooksController@search']);
//        Route::get('create',['as'=>'book.create','uses'=>'BookController@create']);
//        // Route::get('create',['as'=>'book.create','uses'=>'BookController@create','middleware' => ['permission:book-create']]);
//        Route::post('createbook',['as'=>'book.store','uses'=>'BooksController@store']);
//
//        Route::post('createseminar',['as'=>'seminar.store','uses'=>'BooksController@storeseminar']);
//        Route::post('createjournal',['as'=>'journal.store','uses'=>'BooksController@storejournal']);
//        Route::get('item/{id}', [LibraryController::class,  'show'])->name('dashboard.library.view');
//        Route::get('/edit/{id}',['as'=>'dashboard.library.edit',[LibraryController::class,  'edit']]);
//        Route::patch('/edit/{id}',['as'=>'dashboard.library.update',[LibraryController::class,  'update']]);
//        Route::delete('delete/{id}',['as'=>'dashboard.library.delete',[LibraryController::class,  'destroy']]);
//        Route::get('clone/{id}',['as'=>'dashboard.library.clone',[LibraryController::class,  'cloneJournal']]);
//        Route::get('remove/{id}',['as'=>'book.destroy',[LibraryController::class,  'remove']]);
//
//        Route::post('printqr', 'BookController@printqr')->name('dashboard.library.print.qr');
//
//        //search items
//        Route::get('search', 'BookController@index')->name('dashboard.library.search');
//
//        Route::get('/new', [LibraryController::class, 'create'])->name('dashboard.library.create');
//        Route::post('/new', [LibraryController::class, 'store'])->name('dashboard.library.store');
//
//        //Seasons
//        Route::group(['prefix' => 'season', 'middleware' => ['auth']], function()
//        {
//            Route::get('/', 'Dashboard\SeasonController@index')->name('dashboard.season.index');
//            Route::get('/create', 'Dashboard\SeasonController@create')->name('dashboard.season.create');
//            Route::post('/store', 'Dashboard\SeasonController@store')->name('dashboard.season.store');
//            Route::get('/edit/{id}', 'Dashboard\SeasonController@edit')->name('dashboard.season.edit');
//            Route::put('/update/{id}', 'Dashboard\SeasonController@update')->name('dashboard.season.update');
//            Route::delete('/delete/{id}', 'Dashboard\SeasonController@destroy')->name('dashboard.season.delete');
//        });
//    });
//
//    //Stock
//    Route::group(['prefix' => 'stock', 'middleware' => ['auth']], function()
//    {
//        Route::get('/',['as'=>'dashboard.stock.index','uses'=>'Dashboard\StockController@index','middleware' => ['permission:book-list|book-create|book-edit|book-delete']]);
//        Route::get('add/{id}',['as'=>'book.search','uses'=>'Dashboard\StockController@search','middleware' => ['permission:book-list|book-create|book-edit|book-delete']]);
//        Route::get('delete/{id}',['as'=>'book.search','uses'=>'Dashboard\StockController@search','middleware' => ['permission:book-list|book-create|book-edit|book-delete']]);
//    });
//
//    //library issue
//    Route::get('issue',['as'=>'book_issue.index','uses'=>'Dashboard\IssueController@index','middleware' => ['permission:book_issue|book-issues-list|book-issues-create|book-issues-edit|book-issues-delete']]);
//    Route::get('issue/create',['as'=>'book_issue.create','uses'=>'Dashboard\IssueController@create','middleware' => ['permission:book-issues-create']]);
//    Route::get('issue/create/{id}',['as'=>'book_issue.create','uses'=>'Dashboard\IssueController@create','middleware' => ['permission:book-issues-create']]);
//    Route::post('issue/create',['as'=>'book_issue.store','uses'=>'Dashboard\IssueController@store','middleware' => ['permission:book-issues-create']]);
//    Route::get('issue/view/{id}',['as'=>'book_issue.show','uses'=>'Dashboard\IssueController@show']);
//    Route::get('issue/{id}/edit',['as'=>'book_issue.edit','uses'=>'Dashboard\IssueController@edit','middleware' => ['permission:book-issues-edit']]);
//    Route::patch('issue/edit/{id}',['as'=>'book_issue.update','uses'=>'Dashboard\IssueController@update','middleware' => ['permission:book-issues-edit']]);
//    Route::delete('issue/delete/{id}',['as'=>'book_issue.destroy','uses'=>'Dashboard\IssueController@destroy','middleware' => ['permission:book-issues-delete']]);
//
//    Route::get('issue/extend/{id}', 'Dashboard\IssueController@extend')->name('dashboard.issue.extend');
//    Route::get('issue/return/{id}', 'Dashboard\IssueController@takereturn')->name('dashboard.issue.return');
//
//    //book issue
//    Route::get('changecopy/ajax/{id}',array('as'=>'mychangecopy.ajax','uses'=>'Dashboard\IssueController@mychangecopyAjax'));
//
//    Route::get('get_data_by_qr_string/ajax/{string}',array('as'=>'get_data_by_qr_string.ajax','uses'=>'Dashboard\IssueController@getDataByQrString'));
//
//    //issues expired list
//    Route::get('book_issues/expired',['uses'=>'Dashboard\IssueController@expiredIndex','middleware' => ['permission:book_issue|book-issues-list|book-issues-create|book-issues-edit|book-issues-delete']]);
//    // return of this week list
//    Route::get('book_issues/return',['uses'=>'Dashboard\ReturnController@returnWeekIndex','middleware' => ['permission:book_issue|book-issues-list|book-issues-create|book-issues-edit|book-issues-delete']]);
//
//    //book return
//    Route::group(['prefix' => 'return', 'middleware' => ['auth']], function()
//    {
//        Route::get('/',['as'=>'book_return.index','uses'=>'Dashboard\ReturnController@index','middleware' => ['permission:book_return|book-issues-list|book-issues-create|book-issues-edit|book-issues-delete']]);
//        Route::get('create',['as'=>'book_return.create','uses'=>'Dashboard\ReturnController@create','middleware' => ['permission:book-issues-create']]);
//        Route::post('create',['as'=>'book_return.store','uses'=>'Dashboard\ReturnController@store','middleware' => ['permission:book-issues-create']]);
//        Route::get('view/{id}',['as'=>'book_return.show','uses'=>'Dashboard\ReturnController@show']);
//        Route::get('edit/{id}',['as'=>'book_return.edit','uses'=>'Dashboard\ReturnController@edit','middleware' => ['permission:book-issues-edit']]);
//
//        Route::patch('edit/{id}',['as'=>'book_return.update','uses'=>'Dashboard\ReturnController@update','middleware' => ['permission:book-issues-edit']]);
//        Route::delete('delete/{id}',['as'=>'book_return.destroy','uses'=>'Dashboard\ReturnController@destroy','middleware' => ['permission:book-issues-delete']]);
//    });
//
//    //book featured
//    Route::group(['prefix' => 'feature', 'middleware' => ['auth']], function()
//    {
//        Route::get('/', 'Dashboard\FeatureController@index')->name('dashboard.feature.index');
//        Route::get('/create', 'Dashboard\FeatureController@create')->name('dashboard.feature.create');
//        Route::get('/add/{id}', 'Dashboard\FeatureController@add')->name('dashboard.feature.add');
//        Route::patch('/edit/{id}', 'Dashboard\FeatureController@edit')->name('dashboard.feature.edit');
//        Route::delete('/delete/{id}', 'Dashboard\FeatureController@destroy')->name('dashboard.feature.update');
//    });
//
//    //book ret
//    Route::get('myform/ajax/{id}',array('as'=>'myform.ajax','uses'=>'Dashboard\ReturnController@myformAjax'));
//    Route::get('myformQr/ajax/{id}',array('as'=>'myformQr.ajax','uses'=>'Dashboard\ReturnController@myformAjaxQr'));
//
//    //banners
//    Route::get('banners',['as'=>'banners.index','uses'=>'OptionController@index','middleware' => ['permission:banners|banner-list|banner-create|banner-edit|banner-delete']]);
//    Route::get('banners/create',['as'=>'banners.create','uses'=>'OptionController@create','middleware' => ['permission:banner-create']]);
//    Route::post('banners/create',['as'=>'banners.store','uses'=>'OptionController@store','middleware' => ['permission:banner-create']]);
//    Route::get('banners/{id}',['as'=>'banners.show','uses'=>'BookController@show']);
//    Route::get('banners/{id}/edit',['as'=>'banners.edit','uses'=>'OptionController@edit','middleware' => ['permission:book-edit']]);
//    Route::patch('banners/{id}',['as'=>'banners.update','uses'=>'OptionController@update','middleware' => ['permission:book-edit']]);
//    Route::delete('banners/{id}',['as'=>'banners.destroy','uses'=>'OptionController@destroy','middleware' => ['permission:book-delete']]);
});


