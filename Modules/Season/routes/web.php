<?php

use Illuminate\Support\Facades\Route;
use Modules\Season\App\Http\Controllers\SeasonController;

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

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:web'], function () {
    Route::resource('season', SeasonController::class)->names('season');
});
