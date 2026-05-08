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
            // 1. Ambil data statistik dasar
            $totalUsers  = User::count();
            $totalTexts  = text::count();
            $totalGroups = group::count();

            // Gunakan huruf kapital 'Source' jika itu nama Model kamu (sesuaikan dengan file di folder Models)
            $totalImages = source::where('typeFile', 'images')->count();
            $totalVideos = source::where('typeFile', 'video')->count();

            // 2. Logika Waktu (Asia/Jakarta)
            $now = Carbon::now('Asia/Jakarta');
            $todayDay = $now->dayOfWeekIso;

            // 3. Ambil data yang sedang aktif tayang
            $files = source::where('ed_date', '>=', $now)
                            ->whereNotNull('selected_days')
                            ->whereRaw("JSON_CONTAINS(selected_days, '\"$todayDay\"')")
                            ->get();

            // 4. AMBIL 1 KONTEN TERBARU UNTUK PREVIEW (Penting untuk Live Preview)
            $latestContent = source::latest()->first();

            // 5. KEMBALIKAN HANYA SATU RETURN VIEW (Menggabungkan semua variabel)
            return view('dashboard', compact(
                'files',
                'totalUsers',
                'totalImages',
                'totalVideos',
                'totalTexts',
                'totalGroups',
                'latestContent'
            ));
        }
}
