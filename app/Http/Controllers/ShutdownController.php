<?php

namespace App\Http\Controllers;

class ShutdownController extends Controller
{
    public function shutdown()
    {
        $output = [];
        $returnCode = 0;

        // Ganti perintah sesuai dengan sistem operasi yang Anda gunakan
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows
            exec("shutdown /s /t 0", $output, $returnCode);
        } else {
            // Linux atau Unix
            exec("shutdown now", $output, $returnCode);
        }

        // Cetak output dan return code untuk debugging jika diperlukan
        var_dump($output);
        var_dump($returnCode);

        // Atau, jika ingin mengembalikan respons ke pengguna
        return response()->json(['message' => 'System shutdown initiated.']);
    }
}
