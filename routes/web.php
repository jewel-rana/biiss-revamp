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


