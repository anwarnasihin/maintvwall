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
        // --- 1. AMBIL PENGGUNAAN DISK ---
        $diskFree    = disk_free_space("/");
        $diskTotal   = disk_total_space("/");
        $diskUsed    = $diskTotal - $diskFree;
        $diskPercent = round(($diskUsed / $diskTotal) * 100);

        $totalDiskGB = round($diskTotal / (1024 * 1024 * 1024), 1);
        $usedDiskGB  = round($diskUsed / (1024 * 1024 * 1024), 1);

        // --- 2. AMBIL PENGGUNAAN RAM ---
        $totalRamGB = 0;
        $usedRamGB  = 0;
        $memoryPercent = 0;

        // Cek OS: Jika Linux ambil data asli, jika Windows ambil data dummy
        if (PHP_OS_FAMILY === 'Linux') {
            $free = shell_exec('free -b');
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
                    $totalRamGB = round($memoryTotal / (1024 * 1024 * 1024), 1);
                    $usedRamGB  = round($memoryUsed / (1024 * 1024 * 1024), 1);
                }
            }
        } else {
            // Data dummy hanya untuk tampilan saat coding di Windows
            $memoryPercent = rand(20, 40);
            $totalRamGB = 16;
            $usedRamGB = 4;
        }

        // --- 3. AMBIL DATA STATISTIK ---
        $totalUsers  = User::count();
        $totalTexts  = text::count();
        $totalGroups = group::count();
        $totalImages = source::where('typeFile', 'images')->count();
        $totalVideos = source::where('typeFile', 'video')->count();

        // --- 4. LOGIKA WAKTU & FILES ---
        $now = Carbon::now('Asia/Jakarta');
        $todayDay = $now->dayOfWeekIso;

        $files = source::where('ed_date', '>=', $now)
                        ->whereNotNull('selected_days')
                        ->whereRaw("JSON_CONTAINS(selected_days, '\"$todayDay\"')")
                        ->get();

        $latestContent = source::latest()->first();

        // --- 5. KEMBALIKAN VIEW ---
        return view('dashboard', compact(
            'diskPercent', 'totalDiskGB', 'usedDiskGB',
            'memoryPercent', 'totalRamGB', 'usedRamGB',
            'files', 'totalUsers', 'totalImages', 'totalVideos', 'totalTexts', 'totalGroups', 'latestContent'
        ));
    }
}
