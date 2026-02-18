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
        // --- LOGIKA WAKTU (SUDAH DIPERBAIKI) ---
        // Gunakan Timezone Jakarta dan Waktu Lengkap (Jam + Menit)
        $now = Carbon::now('Asia/Jakarta');
        $todayDay = $now->dayOfWeekIso;

        // --- LOGIKA BARU: ABAIKAN START TIME, FOKUS KE END TIME ---
        $files = source::where('ed_date', '>=', $now) // Masih tayang selama belum melewati waktu END
                        ->whereNotNull('selected_days')
                        ->whereRaw("JSON_CONTAINS(selected_days, '\"$todayDay\"')")
                        ->get();

        // ----------------------------------------

        $totalUsers  = User::count();
        // Hitung total images/video dari tabel source
        $totalImages = source::where('typeFile', 'images')->count();
        $totalVideos = source::where('typeFile', 'video')->count();
        $totalTexts  = text::count();
        $totalGroups = group::count();

        return view('dashboard', compact(
            'files',
            'totalUsers',
            'totalImages',
            'totalVideos',
            'totalTexts',
            'totalGroups'
        ));
    }
}
