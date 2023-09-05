<?php

namespace App\Http\Controllers;

use App\Models\group;
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
        // dd($request->all());
        group::create([
            'name' => $request->nama,
            'keterangan' => $request->keterangan,
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
