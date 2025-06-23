<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\source;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->dayOfWeekIso; // 1 = Senin, ..., 7 = Minggu
        $currentDate = Carbon::now()->toDateString();

        $files = source::where('str_date', '<=', $currentDate)
                        ->where('ed_date', '>=', $currentDate)
                        ->whereNotNull('selected_days') // Pastikan selected_days tidak null
                        ->whereRaw("JSON_CONTAINS(selected_days, '\"$today\"')") // Filter berdasarkan hari ini
                        ->get();

        return view('dashboard', compact('files'));
    }
}

