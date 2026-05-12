<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\source;
use App\Models\User;
use App\Models\text;
use App\Models\group;

class HomeController extends Controller
{
    public function index()
    {
        // --- AMBIL PENGGUNAAN DISK (Jalan di Windows & Linux) ---
        $diskFree    = disk_free_space("/");
        $diskTotal   = disk_total_space("/");
        $diskUsed    = $diskTotal - $diskFree;
        $diskPercent = round(($diskUsed / $diskTotal) * 100);

        // Konversi ke GB (dibagi 1024 pangkat 3)
        $totalDiskGB = round($diskTotal / (1024 * 1024 * 1024), 1);
        $usedDiskGB  = round($diskUsed / (1024 * 1024 * 1024), 1);

        // --- AMBIL PENGGUNAAN RAM (Kasih Pengaman untuk Windows) ---
       $totalRamGB = 0;
$usedRamGB  = 0;
$memoryPercent = 0;

if (strtoupper(substr(PHP_OS, 0, 3)) === 'LINUX') {
    $free = shell_exec('free -b'); // Pakai flag -b agar hitungannya dalam bytes
    if ($free) {
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        if (isset($free_arr[1])) {
            $mem = explode(" ", $free_arr[1]);
            $mem = array_filter($mem);
            $mem = array_merge($mem);

            $memoryTotal = $mem[1];
            $memoryUsed  = $mem[2];

            $memoryPercent = round($memoryUsed / $memoryTotal * 100);

            // Konversi ke GB
            $totalRamGB = round($memoryTotal / (1024 * 1024 * 1024), 1);
            $usedRamGB  = round($memoryUsed / (1024 * 1024 * 1024), 1);
        }
    }
} else {
    $memoryPercent = rand(20, 40);
    $totalRamGB = 16; // Dummy untuk Windows
    $usedRamGB = 4;
}

        // 1. Ambil data statistik dasar
        $totalUsers  = User::count();
        $totalTexts  = text::count();
        $totalGroups = group::count();
        $totalImages = source::where('typeFile', 'images')->count();
        $totalVideos = source::where('typeFile', 'video')->count();

        // 2. Logika Waktu (Asia/Jakarta)
        $now = Carbon::now('Asia/Jakarta');
        $todayDay = $now->dayOfWeekIso;

        // 3. Ambil data yang sedang aktif tayang (untuk keperluan lain jika butuh)
        $files = source::where('ed_date', '>=', $now)
                        ->whereNotNull('selected_days')
                        ->whereRaw("JSON_CONTAINS(selected_days, '\"$todayDay\"')")
                        ->get();

        // 4. Ambil 1 konten terbaru
        $latestContent = source::latest()->first();

        // 5. KEMBALIKAN VIEW (Pastikan diskPercent dan memoryPercent dibawa!)
       return view('dashboard', compact(
            'diskPercent', 'totalDiskGB', 'usedDiskGB',
            'memoryPercent', 'totalRamGB', 'usedRamGB',
            'files', 'totalUsers', 'totalImages', 'totalVideos', 'totalTexts', 'totalGroups', 'latestContent'
        ));
    }
}
