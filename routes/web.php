<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('pay', [PaymentController::class, 'store']);
Route::get('channels', [\App\Http\Controllers\ChanalController::class, 'index']);
Route::get('post/create', [\App\Http\Controllers\PostsController::class, 'create']);
