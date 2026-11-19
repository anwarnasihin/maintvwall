<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DisplayApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API khusus perangkat TV Wall
Route::middleware('display.auth')->prefix('display')->group(function () {
    Route::post('/heartbeat', [DisplayApiController::class, 'heartbeat'])
        ->name('display.heartbeat');

    Route::post('/manifest', [DisplayApiController::class, 'manifest'])
    ->name('display.manifest');

    Route::get('/media/{sourceId}/download', [DisplayApiController::class, 'downloadMedia'])
    ->whereNumber('sourceId')
    ->name('display.media.download');
});
