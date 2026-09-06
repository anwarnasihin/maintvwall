<?php

namespace App\Http\Controllers;

use App\Models\text;
use App\Models\group;
use App\Models\source;
use Illuminate\Http\Request;

class UploadtextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dtText = text::with('groups')->get();

        return view('Uploadtext.Datatext', compact('dtText'));
    }

    public function getTexts()
{
    $texts = text::where('status',1)->get();
    return response()->json($texts);
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = group::orderBy('name')->get();

        return view('Uploadtext.Createtext', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'status' => 'required|string',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
        ]);

        $txt = text::create([
            'judul' => $validatedData['judul'],
            'deskripsi' => $validatedData['deskripsi'],
            'status' => $validatedData['status'],
        ]);

        // Hubungkan running text dengan group yang dipilih
        $txt->groups()->sync($request->input('groups', []));

        return redirect('datatext')
            ->with('toast_success', 'Running text berhasil disimpan!');
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
        $txt = text::with('groups')->findOrFail($id);
        $groups = group::orderBy('name')->get();

        return view('Uploadtext.Edittext', compact('txt', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'status' => 'required|string',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
        ]);

        $txt = text::findOrFail($id);

        $txt->update([
            'judul' => $validatedData['judul'],
            'deskripsi' => $validatedData['deskripsi'],
            'status' => $validatedData['status'],
        ]);

        // Sinkronkan group
        $txt->groups()->sync($request->input('groups', []));

        return redirect('datatext')
            ->with('toast_success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $txt = text::findOrFail($id);
        $txt->forceDelete();
        return back()->with('toast_success', 'Data berhasil di hapus!');
    }
}
