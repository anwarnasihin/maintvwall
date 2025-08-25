<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Source;
use App\Models\User;
use App\Models\Text;
use App\Models\Group;


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
        $totalImages = Source::where('typeFile', 'images')->count();
        $totalVideos = Source::where('typeFile', 'video')->count();
        $totalTexts  = Text::count();   // ambil dari tabel texts
        $totalGroups = Group::count();  // ambil dari tabel groups

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
