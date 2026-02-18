<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Cek role user yang baru saja login
        if (auth()->user()->role == 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        // Kalau bukan admin, lempar ke dashboard biasa
        return redirect()->intended('/dashboard');
    }
}
