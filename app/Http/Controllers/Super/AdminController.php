<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function create()
    {
        $departments = \App\Models\Departemen::orderBy('nama_departemen')->get();
        return view('super.admins.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'id_departemen' => 'nullable|exists:departemens,id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'admin',
            'id_departemen' => $data['id_departemen'] ?? null,
        ]);

        return redirect()->route('super.dashboard')->with('success', 'Admin baru berhasil dibuat.');
    }
}
