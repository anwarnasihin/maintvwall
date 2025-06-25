<?php

use App\Models\source;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadfileController;
use App\Http\Controllers\UploadgroupController;
use App\Http\Controllers\UploadtextController;
use App\Http\Controllers\UsersController;
use App\Models\group;
use App\Models\text;
use Illuminate\Http\Request;
use App\Http\Controllers\ShutdownController;
use App\Http\Controllers\HomeController;
use Carbon\Carbon;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

Route::get('/show/{group}', [UploadfileController::class, 'show'])->name('showGroup');

Route::post('/getContent', function (Request $request) {
    $idGroup = group::where('name', $request->group)->first();
    $today = date("Y-m-d");
    $todayday = Carbon::now('Asia/Jakarta')->dayOfWeekIso;

    $dataa = source::where('group', $idGroup->id)
        ->where('str_date', '<=', $today)
        ->where('ed_date', '>=', $today)
        ->whereRaw("JSON_CONTAINS(selected_days, '\"$todayday\"')");

    $token = csrf_token();
    $data = $dataa->get();
    $texts = text::where('status', 1)->get();

    return response()->json([$data, $texts, $token]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/download', function (Request $request) {
    $filePath = public_path($request->konten);
    return response()->download($filePath);
})->name('download');

// FILE
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/datafile', [UploadfileController::class, 'index'])->name('datafile');
    Route::get('/createfile', [UploadfileController::class, 'create'])->name('createfile');
    Route::post('/simpanfile', [UploadfileController::class, 'store'])->name('simpanfile');
    Route::get('/editfile/{id}', [UploadfileController::class, 'edit'])->name('editfile');
    Route::post('/updatefile/{id}', [UploadfileController::class, 'update'])->name('updatefile');
    Route::post('/editDuration', [UploadfileController::class, 'updateDuration'])->name('editDuration');
    Route::get('/deletefile/{id}', [UploadfileController::class, 'destroy'])->name('deletefile');

    // GROUP
    Route::get('/datagroup', [UploadgroupController::class, 'index'])->name('datagroup');
    Route::get('/creategroup', [UploadgroupController::class, 'create'])->name('creategroup');
    Route::post('/simpangroup', [UploadgroupController::class, 'store'])->name('simpangroup');
    Route::get('/editgroup/{id}', [UploadgroupController::class, 'edit'])->name('editgroup');
    Route::post('/updategroup/{id}', [UploadgroupController::class, 'update'])->name('updategroup');
    Route::get('/deletegroup/{id}', [UploadgroupController::class, 'destroy'])->name('deletegroup');

    // USERS
    Route::get('/datausers', [UsersController::class, 'index'])->name('datausers');
    Route::post('/simpanuser', [UsersController::class, 'store'])->name('simpanuser');
    Route::post('/edituser', [UsersController::class, 'edit'])->name('edituser');
    Route::post('/updateuser/{id}', [UsersController::class, 'update'])->name('updateuser');
    Route::get('/deleteuser/{id}', [UsersController::class, 'destroy'])->name('deleteuser');

    // TEXT
    Route::get('/datatext', [UploadtextController::class, 'index'])->name('datatext');
    Route::get('/createtext', [UploadtextController::class, 'create'])->name('createtext');
    Route::post('/simpantext', [UploadtextController::class, 'store'])->name('simpantext');
    Route::get('/edittext/{id}', [UploadtextController::class, 'edit'])->name('edittext');
    Route::post('/updatetext/{id}', [UploadtextController::class, 'update'])->name('updatetext');
    Route::get('/deletetext/{id}', [UploadtextController::class, 'destroy'])->name('deletetext');
});

Route::post('/getTexts', [UploadtextController::class, 'getTexts'])->name('getTexts');

Route::match(['get', 'post'], '/shutdown', [ShutdownController::class, 'shutdown']);
