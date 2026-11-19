<?php

namespace App\Http\Middleware;

use App\Models\Display;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateDisplay
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil token dari Authorization: Bearer <token>
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token autentikasi tidak ditemukan.',
            ], 401);
        }

        // Cocokkan hash token dengan database.
        $tokenHash = hash('sha256', $token);

        $display = Display::where('api_token_hash', $tokenHash)
            ->first();

        if (!$display) {
            return response()->json([
                'success' => false,
                'message' => 'Token autentikasi tidak valid.',
            ], 401);
        }

        if (!$display->is_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Perangkat Display dinonaktifkan.',
            ], 403);
        }

        // Simpan identitas Display pada request.
        // Controller berikutnya dapat mengambilnya dari atribut ini.
        $request->attributes->set('authenticated_display', $display);

        return $next($request);
    }
}
