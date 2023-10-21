<?php

namespace App\Http\Controllers;

use App\Models\text;
use App\Models\source;
use Illuminate\Http\Request;

class UploadtextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $dtText = Text::all();
        return view('Uploadtext.Datatext', compact('dtText'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Uploadtext.Createtext');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        Text::create([
            'judul' => $validatedData['judul'],
            'deskripsi' => $validatedData['deskripsi'],
        ]);
    
        return redirect('datatext');
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
        $txt = Text::findorfail($id);
        return view('Uploadtext.Edittext',compact('txt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $txt = Text::findorfail($id);
        $txt->update($request->all());
        return redirect('datatext')->with('toast_success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $txt = Text::findOrFail($id); 
        $txt->forceDelete();
        return back()->with('toast_success', 'Data berhasil di hapus!');
    }
}
