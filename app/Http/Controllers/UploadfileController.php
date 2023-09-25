<?php

namespace App\Http\Controllers;

use App\Models\group;
use App\Models\source;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $group = group::get();
        return view('Uploadfile.Createfile', ['group' => $group]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->typeFile != "youtube") {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileInput = 'assets/' . $request->typeFile . '/' . $filename;
        } else {
            $fileInput = $request->linkYoutube;
        }
        // dd($request->all());
        $postt = new source();
        $postt->group = $request->group;
        $postt->typeFile = $request->typeFile;
        $postt->direktori = $fileInput;
        $postt->duration = $request->duration != null ? $request->duration : 0;
        $postt->str_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->str_date)));
        $postt->ed_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->ed_date)));
        $postt->users = Auth::user()->id;
        $postt->save();

        if ($postt->id && $request->typeFile != "youtube") {
            if ($postt->id) {
                $file->move(public_path('assets/' . $request->typeFile . '/'), $filename);
            }
        }

        return redirect('datafile')->with('toast_success', 'Data berhasil di simpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $dt = Source::findorfail($request->id);
        $dt->duration = $request->duration > 0 ? $request->duration : 0;
        if ($request->str_date != null) {
            $dt->str_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->str_date)));
        }
        if ($request->ed_date != null) {
            $dt->ed_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->ed_date)));
        }
        $dt->save();

        return redirect('datafile')->with('toast_success', 'Data berhasil di update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dt = Source::find($id); // Untuk mengambil data yang sudah dihapus
        $dt->forceDelete(); // Untuk menghapus secara permanen

        if (file_exists(public_path($dt->direktori))) {
            unlink(public_path($dt->direktori));
        }

        return back()->with('toast_success', 'Data berhasil di hapus!');
    }
}
