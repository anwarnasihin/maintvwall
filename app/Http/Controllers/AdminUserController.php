<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // 1. Menampilkan Daftar User
    public function index()
    {
        // Ambil semua user, termasuk akun yang sedang login
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    // 2. Menampilkan Form Tambah User (INI TADI KURANG)
    public function create()
    {
        return view('admin.users.create');
    }

    // 3. Menyimpan User Baru (Store)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:30|alpha_dash|unique:users,username',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    // 4. Menampilkan Form Edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // 5. Menyimpan Perubahan (Update)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|string|min:3|max:30|alpha_dash|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,user',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 6. Menghapus User (Cukup satu saja)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
