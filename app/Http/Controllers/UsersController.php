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

    // dd($request->all());
    $request->validate([

        'nama'=> 'required',
        'email' => 'required|unique:users',
        'password' => 'required',
        
    ]);

    // Simpan data ke dalam tabel pengguna
        $user = new User;
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level = '';
        $user->save();;

    // Alihkan pengguna setelah data disimpan
    return response()->json($user);
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
    public function edit(Request $request)
    {
        $usr = User::find($request->id);
        return response()->json($usr);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([

            'nama'=> 'required',
            'email' => 'required',
            
        ]);

        $user = User::find($id);
        $user->name = $request->nama;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->level = '';
        $user->save();;

    // Alihkan pengguna setelah data disimpan
    return response()->json($user);
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
