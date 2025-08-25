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
        $today = Carbon::now()->dayOfWeekIso; // 1 = Senin, ..., 7 = Minggu
        $currentDate = Carbon::now()->toDateString();

        $files = source::where('str_date', '<=', $currentDate)
                        ->where('ed_date', '>=', $currentDate)
                        ->whereNotNull('selected_days')
                        ->whereRaw("JSON_CONTAINS(selected_days, '\"$today\"')")
                        ->get();

        // Debug typeFile unik
        // $allTypes = Source::select('typeFile')->distinct()->pluck('typeFile');
        // dd($allTypes); // sementara untuk cek data

        // Nanti setelah cek hasil di atas, baru aktifkan lagi yang bawah ini

        $totalUsers  = User::count();
        $totalImages = source::where('typeFile', 'images')->count();
        $totalVideos = source::where('typeFile', 'video')->count();
        $totalTexts  = text::count();   // ambil dari tabel texts
        $totalGroups = group::count();  // ambil dari tabel groups

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
