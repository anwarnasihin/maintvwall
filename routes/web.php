<?php

use App\Models\source;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;
use App\Http\Controllers\UploadfileController;
use App\Http\Controllers\UploadgroupController;
use App\Http\Controllers\UploadtextController;
use App\Http\Controllers\UsersController;
use App\Models\group;
use App\Models\text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
    return redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('/dashboard');
    })->name('dashboard');
});
Route::get('/show/{group}', function ($group) {
    $dtText = text::where('status',1)->get(); // Mengambil semua data teks dari database
    return view('vidgam', ['group' => $group,'dtText'=>$dtText]);
});
Route::post('/getContent', function (Request $request) {
    $idGroup = group::where('name', $request->group)->first();
    $dataa = source::where(function ($query) use ($idGroup) {
        $today = date("Y-m-d");
        $query->where('group', '=', $idGroup->id)
            ->where('str_date', '>=', $today)
            ->orWhere(function ($query) use ($today, $idGroup) {
                $query->where('str_date', '<', $today)
                    ->where('ed_date', '>=', $today)
                    ->where('group', $idGroup->id);
            });
    });
    $data = $dataa->get();
    //return $data;
    return response()->json($data);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/download', function (Request $request) {
    $filePath = public_path($request->konten);
    return response()->download($filePath);
})->name('download');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/datafile', [UploadfileController::class, 'index'])->name('datafile');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/createfile', [UploadfileController::class, 'create'])->name('createfile');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/simpanfile', [UploadfileController::class, 'store'])->name('simpanfile');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/editfile/{id}', [UploadfileController::class, 'edit'])->name('editfile');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/updatefile/{id}', [UploadfileController::class, 'update'])->name('updatefile');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/editDuration', [UploadfileController::class, 'updateDuration'])->name('editDuration');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/deletefile/{id}', [UploadfileController::class, 'destroy'])->name('deletefile');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/datagroup', [UploadgroupController::class, 'index'])->name('datagroup');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/creategroup', [UploadgroupController::class, 'create'])->name('creategroup');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/simpangroup', [UploadgroupController::class, 'store'])->name('simpangroup');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/editgroup/{id}', [UploadgroupController::class, 'edit'])->name('editgroup');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/updategroup/{id}', [UploadgroupController::class, 'update'])->name('updategroup');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/deletegroup/{id}', [UploadgroupController::class, 'destroy'])->name('deletegroup');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/datausers', [UsersController::class, 'index'])->name('datausers');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/simpanuser', [UsersController::class, 'store'])->name('simpanuser');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/edituser', [UsersController::class, 'edit'])->name('edituser');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/updateuser/{id}', [UsersController::class, 'update'])->name('updateuser');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/deleteuser/{id}', [UsersController::class, 'destroy'])->name('deleteuser');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/datatext', [UploadtextController::class, 'index'])->name('datatext');
Route::get('/getTexts', [UploadtextController::class, 'getTexts'])->name('getTexts');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/createtext', [UploadtextController::class, 'create'])->name('createtext');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/simpantext', [UploadtextController::class, 'store'])->name('simpantext');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/edittext/{id}', [UploadtextController::class, 'edit'])->name('edittext');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/updatetext/{id}', [UploadtextController::class, 'update'])->name('updatetext');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/deletetext/{id}', [UploadtextController::class, 'destroy'])->name('deletetext');
