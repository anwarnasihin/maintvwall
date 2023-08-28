<?php

namespace App\Http\Controllers;

use App\Models\source;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;


class UploadfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataFile = Source::latest()->get(); // Menggunakan metode get()
        return view('Uploadfile.Datafile',compact('dataFile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Uploadfile.Createfile');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        Source::create([
            'group' => $request->group,
            'typeFile' => $request->typeFile,
            'direktori' => $request->direktori,
            'duration' => $request->duration,
        ]);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dt = Source::withTrashed()->findOrFail($id); // Untuk mengambil data yang sudah dihapus
        $dt->forceDelete(); // Untuk menghapus secara permanen

        return back()->with('toast_success', 'Data berhasil di hapus!');
    }
}
