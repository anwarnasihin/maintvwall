<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Source;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UploadfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataFile = Source::with('groups', 'user')->latest()->get(); // Menggunakan metode get()
        return view('Uploadfile.Datafile', compact('dataFile'), ['judul' => 'Data Source']);
    }

    public function oldIndex()
    {
        $dataFile = Source::with('groups', 'user')->latest()->get();
        return view('Uploadfile.Datafile', compact('dataFile'), ['judul' => 'Data Source']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $group = group::get();
        return view('Uploadfile.Createfile', ['group' => $group]);
    }

    public function oldCreate()
    {
        $group = group::get();
        return view('Uploadfile.Createfile', ['group' => $group]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $strDate = str_replace('/', '-', $request->str_date);
        $edDate = str_replace('/', '-', $request->ed_date);

        // Validasi input
        $request->validate([
            'group' => 'required',
            'typeFile' => 'required',
            'file' => 'required_without:linkYoutube|mimes:jpg,jpeg,png,mp4',
            'linkYoutube' => 'required_without:file',
            'str_date' => 'required|date',
            'ed_date' => 'required|date|after_or_equal:str_date',
            'selected_days' => 'required|array', // Pastikan user memilih minimal 1 hari
        ]);

        // Proses penyimpanan file
        if ($request->typeFile != "youtube") {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileInput = 'assets/' . $request->typeFile . '/' . $filename;
        } else {
            $fileInput = $request->linkYoutube;
        }

        // Simpan data ke database
        $postt = new source();
        $postt->group = $request->group;
        $postt->typeFile = $request->typeFile;
        $postt->direktori = $fileInput;
        $postt->duration = $request->duration ?? 0;
        $postt->str_date = date("Y-m-d", strtotime($strDate));
        $postt->ed_date = date("Y-m-d", strtotime($edDate));
        $postt->selected_days = json_encode($request->selected_days); // Simpan sebagai JSON
        $postt->users = Auth::user()->id;

        $postt->save();

        if ($postt->id && $request->typeFile != "youtube") {
            if ($postt->id) {
                $file->move(public_path('assets/' . $request->typeFile . '/'), $filename);
            }
        }

        // Jika penyimpanan berhasil, arahkan kembali ke halaman `datafile`
        return redirect()->route('datafile')->with('toast_success', 'Data berhasil disimpan!');
    }


    public function show($group)
    {
        $today = Carbon::now('Asia/Jakarta')->dayOfWeekIso; // 1 = Senin, ..., 7 = Minggu
        $currentDate = Carbon::now()->toDateString();

        // Ambil data berdasarkan filter
        $files = source::where('group', $group)
            ->where('str_date', '<=', $currentDate)
            ->where('ed_date', '>=', $currentDate)
            ->whereRaw("JSON_CONTAINS(selected_days, '\"$today\"')")
            ->get();

        return view('vidgam', compact('files', 'group'));
    }







    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dt = Source::findorfail($id);
        return view('Uploadfile.Editfile', compact('dt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dt = Source::findorfail($id);
        $dt->update($request->all());

        return redirect('datafile')->with('toast_success', 'Data berhasil di update!');
    }

    public function updateDuration(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sources,id',
            'duration' => 'nullable|numeric|min:0',
            'str_date' => 'nullable|date',
            'ed_date' => 'nullable|date|after_or_equal:str_date',
            'selected_days' => 'nullable|array',
        ]);

        $dt = Source::findorfail($request->id);

        // Update duration (only for images)
        if ($request->has('duration')) {
            $dt->duration = $request->duration > 0 ? $request->duration : 0;
        }

        // Update dates
        if ($request->str_date != null) {
            $dt->str_date = date("Y-m-d", strtotime($request->str_date));
        }
        if ($request->ed_date != null) {
            $dt->ed_date = date("Y-m-d", strtotime($request->ed_date));
        }

        // Update selected days
        if ($request->has('selected_days') && is_array($request->selected_days)) {
            $dt->selected_days = json_encode($request->selected_days);
        }

        $dt->save();

        return redirect('datafile')->with('toast_success', 'Media settings updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dt = Source::find($id); // Untuk mengambil data yang sudah dihapus
        $dt->forceDelete(); // Untuk menghapus secara permanen

        if ($dt->direktori && file_exists(storage_path('app/public/' . $dt->direktori))) {
            unlink(storage_path('app/public/' . $dt->direktori));
        }

        return back()->with('toast_success', 'Data berhasil di hapus!');
    }
}
