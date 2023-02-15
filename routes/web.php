<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\PostCard;
use App\PostCardSendingService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use  Illuminate\Support\Str ;

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

Route::get('postcard',function (){
$postcartd=  new PostCardSendingService("USA",5,4) ;
$postcartd->hello("hi osama",'osama.moh.almamari@gmail.com');
});

Route::get('/facades',function (){

    PostCard::hello("hi osama",'osama.moh.almamari@gmail.com');
});

Route::get('macro',function (){

    dump(Str::partNumber("Osama"),Str::prefix("Osama","Eng:"));
});

Route::get('macro2',function (){

    return Response::errorJson("message",404);
});


Route::get('posts',[\App\Http\Controllers\PostController::class,'index']);
Route::get('customers',[CustomerController::class,'index']);
Route::get('customers/{id}/update',[CustomerController::class,'update']);
Route::get('customers/{id}/delete ',[CustomerController::class,'delete']);
Route::get('customers/{id}',[CustomerController::class,'show']);

