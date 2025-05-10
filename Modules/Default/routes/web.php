<?php

use Illuminate\Support\Facades\Route;
use Modules\Default\App\Http\Controllers\DefaultController;

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

Route::group([], function () {
    Route::resource('default', DefaultController::class)->names('default');
});
