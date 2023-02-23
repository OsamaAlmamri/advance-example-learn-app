<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\PostCard;
use App\PostCardSendingService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\LazyCollection;
use  Illuminate\Support\Str;
use App\Jobs\TestJob;
use App\Models\Task;
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


use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



require __DIR__.'/auth.php';



Route::get('pay', [PaymentController::class, 'store']);
Route::get('channels', [\App\Http\Controllers\ChanalController::class, 'index']);
Route::get('post/create', [\App\Http\Controllers\PostsController::class, 'create']);

Route::get('postcard', function () {
    $postcartd = new PostCardSendingService("USA", 5, 4);
    $postcartd->hello("hi osama", 'osama.moh.almamari@gmail.com');
});

Route::get('/facades', function () {

    PostCard::hello("hi osama", 'osama.moh.almamari@gmail.com');
});

Route::get('macro', function () {

    dump(Str::partNumber("Osama"), Str::prefix("Osama", "Eng:"));
});

Route::get('macro2', function () {

    return Response::errorJson("message", 404);
});


Route::get('posts', [\App\Http\Controllers\PostController::class, 'index']);
Route::get('customers', [CustomerController::class, 'index']);
Route::get('customers/{id}/update', [CustomerController::class, 'update']);
Route::get('customers/{id}/delete ', [CustomerController::class, 'delete']);
Route::get('customers/{id}', [CustomerController::class, 'show']);


Route::get('lazy', function () {

//    $collection = Collection::times(6000000)
//        ->map(function ($number) {
//            return pow(2, $number);
//        })->all();

    // allow get huge data
    $collection = LazyCollection::times(6000000)
        ->map(function ($number) {
            return pow(2, $number);
        })->all();

    return "done!";
});


Route::get('q', function () {

    $task = new Task();
    $task->data = "test";
    $task->status = "pending";
    $task->save();
    return dd("done");

//    $job = new TestJob($task);
//
//    $this->dispatch($job);
});

Route::get('q2', function () {

    $task = new Task();
    $task->data = "test";
    $task->status = "pending";
    $task->save();
    \Illuminate\Support\Facades\Bus::dispatch(
        new TestJob($task)
    );

});

Route::get('q3', function () {

    $task = new Task();
    $task->data = "test";
    $task->status = "pending";
    $task->save();
    TestJob::dispatch($task);
});

Route::resource("products", \App\Http\Controllers\ProductController::class);
