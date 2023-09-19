<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dtUser = User::all();
        return view('Datausers', compact('dtUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Datausers');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data dari request
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Simpan data pengguna ke database
        $user = new User;
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level = "";
        $user->save();

        return response()->json(['message' => 'Data pengguna berhasil disimpan'], 200);
        
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
        $usr = User::findorfail($id);
        return view('Datauser', compact('usr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usr = User::findorfail($id);
        $usr->update($request->all());

        return back()->with('toast_success', 'Data berhasil di Update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usr = User::findOrFail($id);
        $usr->forceDelete();
        return back()->with('toast_success', 'Data berhasil di hapus!');
    }
}
