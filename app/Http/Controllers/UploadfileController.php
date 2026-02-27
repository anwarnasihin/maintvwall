<?php

namespace App\Http\Controllers;

use App\Models\group;
use App\Models\source;
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
        $dataFile = source::with('groups', 'user')->latest()->get();
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
    public function store(Request $request)
    {
        // 1. Validasi input (Sama seperti sebelumnya, tapi file sekarang array)
        // 1. Validasi input
        $request->validate([
            'group' => 'required',
            'typeFile' => 'required',

            // PERBAIKAN DI SINI BOSS:
            // 'file' harus divalidasi sebagai array dulu, baru isinya (file.*) dicek mimes-nya
            'file' => 'required_without:linkYoutube|array',
            'file.*' => 'mimes:jpg,jpeg,png,mp4',

            'linkYoutube' => 'required_without:file',
            'str_date' => 'required|date_format:Y-m-d H:i:s',
            'ed_date' => 'required|date_format:Y-m-d H:i:s',
            'selected_days' => 'required|array',
        ]);

        // 2. Jika tipenya YouTube (Hanya satu link, tidak perlu looping file)
        if ($request->typeFile == "youtube") {
            $this->saveEntry($request, $request->linkYoutube);
        }
        // 3. Jika upload file (Bisa banyak sekaligus)
        else if ($request->hasFile('file')) {
            $files = $request->file('file');

            foreach ($files as $file) {
                // Buat nama unik untuk tiap file
                $filename = time() . '_' . $file->getClientOriginalName();
                $fileInput = 'assets/' . $request->typeFile . '/' . $filename;

                // Pindahkan file ke folder tujuan
                $file->move(public_path('assets/' . $request->typeFile . '/'), $filename);

                // Simpan ke database satu per satu
                $this->saveEntry($request, $fileInput);
            }
        }

        return redirect()->route('datafile')->with('toast_success', 'Semua data berhasil disimpan!');
    }


    public function show($group) // Nama parameter kita balikin jadi $group
    {
        // 1. Cari Group ID berdasarkan Nama (misal "test")
        $groupData = group::where('name', $group)->first();

        // Fallback: Kalau tidak ketemu by Name, cari by ID
        if(!$groupData) {
             $groupData = group::find($group);
        }

        $groupId = $groupData ? $groupData->id : null;

        // 2. Filter Waktu (Jam & Menit)
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->dayOfWeekIso; // 1 = Senin...

        // --- LOGIKA BARU: HANYA CEK ED_DATE (WAKTU BERAKHIR) ---
        $files = source::where('group', $groupId)
            ->where('ed_date', '>=', $now) // Selama waktu sekarang belum melewati batas END, tampilkan!
            ->whereRaw("JSON_CONTAINS(selected_days, '\"$today\"')")
            ->get();

        return view('vidgam', compact('files', 'group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dt = source::findorfail($id);
        return view('Uploadfile.Editfile', compact('dt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $dt = source::findorfail($id);

    // Ambil semua data kecuali tanggal dulu
    $input = $request->except(['str_date', 'ed_date']);

    // Paksa format tanggal & jam pakai Carbon agar Linux tidak bingung
    $input['str_date'] = \Carbon\Carbon::parse($request->str_date)->format('Y-m-d H:i:s');
    $input['ed_date'] = \Carbon\Carbon::parse($request->ed_date)->format('Y-m-d H:i:s');

    $dt->update($input);

    return redirect('datafile')->with('toast_success', 'Data berhasil di update dengan jam yang benar!');
}

    public function updateDuration(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sources,id',
            'duration' => 'nullable|numeric|min:0',
            'str_date' => 'nullable',
            'ed_date' => 'nullable',
            'selected_days' => 'nullable|array',
        ]);

        $dt = source::findorfail($request->id);

        if ($request->has('duration')) {
            $dt->duration = $request->duration > 0 ? $request->duration : 0;
        }

        // --- PERBAIKAN 3: UPDATE TANGGAL + JAM ---
        if ($request->str_date != null) {
            $dt->str_date = \Carbon\Carbon::parse($request->str_date)->format('Y-m-d H:i:s');
        }
        if ($request->ed_date != null) {
            $dt->ed_date = \Carbon\Carbon::parse($request->ed_date)->format('Y-m-d H:i:s');
        }
        // -----------------------------------------

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
        $dt = source::find($id);

        if ($dt) {
            // Path lengkap ke file di folder public
            $filePath = public_path($dt->direktori);

            // Cek apakah file benar-benar ada di folder assets, lalu hapus
            if (file_exists($filePath) && is_file($filePath)) {
                unlink($filePath);
            }

            // Hapus data dari database
            $dt->forceDelete();
        }

        return back()->with('toast_success', 'Data dan File berhasil dihapus permanen!');
    }

    /**
     * FUNGSI BARU UNTUK SIMPAN DATA KE DATABASE
     * Letakkan di dalam class UploadfileController, paling bawah sebelum penutup class
     */
    private function saveEntry($request, $fileInput)
    {
        $postt = new source();
        $postt->group = $request->group;
        $postt->typeFile = $request->typeFile;
        $postt->direktori = $fileInput;
        $postt->duration = $request->duration ?? 0;

        // Simpan Jam Lengkap (Y-m-d H:i:s)
        $postt->str_date = \Carbon\Carbon::parse($request->str_date)->format('Y-m-d H:i:s');
        $postt->ed_date = \Carbon\Carbon::parse($request->ed_date)->format('Y-m-d H:i:s');

        $postt->selected_days = json_encode($request->selected_days);
        $postt->users = Auth::user()->id; // Pastikan Auth sudah di-import di atas

        $postt->save();
    }

    public function bulkDelete(Request $request)
        {
            $ids = $request->ids;
            $items = source::whereIn('id', explode(",", $ids))->get();

            foreach ($items as $item) {
                $filePath = public_path($item->direktori);
                // Hapus file fisik dulu Boss
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }
                // Baru hapus datanya
                $item->forceDelete();
            }

            return response()->json(['success' => "Konten masal berhasil dibersihkan!"]);
        }
}
