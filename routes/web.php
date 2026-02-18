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
    // 1. Ambil Group ID
    $idGroup = group::where('name', $request->group)->first();

    // Pastikan group ketemu biar tidak error
    if(!$idGroup) return response()->json([[], [], csrf_token()]);

    // 2. Query Data - ABAIKAN JAM MULAI (STR_DATE)
    $now = Carbon::now('Asia/Jakarta');
    $todayday = $now->dayOfWeekIso;

    $data = source::where('group', $idGroup->id)
        ->where('ed_date', '>=', $now) // Cukup cek apakah belum melewati waktu berakhir
        ->whereRaw("JSON_CONTAINS(selected_days, '\"$todayday\"')")
        ->get();

    $token = csrf_token();
    $texts = Text::where('status', 1)->get();

    // Kembalikan Data
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
Route::delete('/hapus-masal', [UploadfileController::class, 'bulkDelete'])->name('hapusmasal');
Route::match(['get', 'post'], '/shutdown', [ShutdownController::class, 'shutdown']);

Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        // 1. Hitung User
        $totalUsers = \App\Models\User::count();

        // 2. Hitung Group (Pakai model 'group' huruf kecil sesuai kodingan Mas)
        $totalGroups = \App\Models\group::count();

        // 3. Hitung Text (Pakai model 'text')
        $totalTexts  = \App\Models\text::count();

        // 4. Hitung File Upload (Pakai model 'source')
        // Karena saya belum tau cara bedakan video/gambar di database Mas,
        // kita hitung total file yang ada di tabel source saja.
        $totalImages = \App\Models\source::count();
        $totalVideos = 0; // Sementara 0 dulu, atau mau disamakan dengan source juga boleh

        // Kirim semua variabel angka ini ke tampilan
        return view('admin.dashboard', compact('totalUsers', 'totalImages', 'totalVideos', 'totalTexts', 'totalGroups'));
    })->name('dashboard');

    // Route Resource Users (JANGAN DIHAPUS)
    Route::resource('users', \App\Http\Controllers\AdminUserController::class);
});
