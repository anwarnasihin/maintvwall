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
use App\Http\Controllers\ShutdownController;
use App\Http\Controllers\HomeController;
use Carbon\Carbon;

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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    });


Route::get('/show/{group}', [UploadfileController::class, 'show'])->name('showGroup');

Route::post('/getContent', function (Request $request) {
    $idGroup = group::where('name', $request->group)->first();

    $dataa = source::where(function ($query) use ($idGroup) {
        $today = date("Y-m-d");
        $todayday = Carbon::now('Asia/Jakarta')->dayOfWeekIso; // 1 = Senin, ..., 7 = Minggu
        $query->where('group', '=', $idGroup->id)
            ->where(function ($query) use ($today, $idGroup, $todayday) {
                $query->where('str_date', '<=', $today)
                    ->where('ed_date', '>=', $today)
                    ->whereRaw("JSON_CONTAINS(selected_days, '\"$todayday\"')")
                    ->where('group', $idGroup->id);
            });
    });
    $token = csrf_token();
    //GET RUNNING TEXT
    $data = $dataa->get();
    $texts = Text::where('status', 1)->get();
    //return $data;
    return response()->json([$data, $texts, $token]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/download', function (Request $request) {
    $filePath = public_path($request->konten);
    return response()->download($filePath);
})->name('download');

Route::get('/datafile', [UploadfileController::class, 'index'])->name('datafile'); //new


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
Route::post('/getTexts', [UploadtextController::class, 'getTexts'])->name('getTexts');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/createtext', [UploadtextController::class, 'create'])->name('createtext');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/simpantext', [UploadtextController::class, 'store'])->name('simpantext');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/edittext/{id}', [UploadtextController::class, 'edit'])->name('edittext');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->post('/updatetext/{id}', [UploadtextController::class, 'update'])->name('updatetext');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->get('/deletetext/{id}', [UploadtextController::class, 'destroy'])->name('deletetext');

Route::match(['get', 'post'], '/shutdown', [ShutdownController::class, 'shutdown']);
