<?php

namespace App\Http\Controllers;

use App\Models\group;
use App\Models\source;
use Illuminate\Http\Request;

class UploadgroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dtGroup = group::all();
        return view('Uploadgroup.Datagroup', compact('dtGroup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Uploadgroup.Creategroup');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        // Menghapus spasi dari input 'nama' dan 'keterangan'
        $nama = str_replace(' ', '', $request->input('nama'));

        // Simpan data yang telah dihapus spasi
        Group::create([
            'name' => $nama,
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect('datagroup');
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
        $gro = Group::findorfail($id);
        return view('Uploadgroup.Editgroup', compact('gro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gro = Group::findorfail($id);
        $gro->update($request->all());
        return redirect('datagroup')->with('toast_success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gro = Group::findOrFail($id);
        $gro->forceDelete();
        return back()->with('toast_success', 'Data berhasil di hapus!');
    }
}
