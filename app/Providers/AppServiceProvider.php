<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Laravel\Fortify\Http\Responses\RegisterResponse;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // JURUS ALTERNATIF: Langsung tembak ke kontrak Fortify
    $this->app->singleton(\Laravel\Fortify\Contracts\RegisterResponse::class, function () {
        return new class implements \Laravel\Fortify\Contracts\RegisterResponse {
            public function toResponse($request)
            {
                // Paksa logout agar tidak langsung masuk dashboard
                auth()->logout();

                // Lempar ke login dengan pesan sukses
                return redirect()->route('login')->with('toast_success', 'Akun berhasil dibuat, Silakan Login Booss!');
            }
        };
    });
    }
}
