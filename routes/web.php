<?php

use App\Models\source;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;
use App\Http\Controllers\HomeController;

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



Route::get('/tvwall', function () {
    $data = source::get();
    //return $data;
    return view('vidgam', ['data' => $data]);
});

// Route::get('/vidgam', [HomeController::class, 'vidgam'])->name('vidgam');
