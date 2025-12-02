<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDetailController extends Controller
{
    /**
     * Display admin list for a specific department.
     */
    public function show($departemen_id)
    {
        $departemen = Departemen::findOrFail($departemen_id);
        $admins = User::where('role', 'admin')
            ->where('id_departemen', $departemen_id)
            ->orderBy('name')
            ->get();

        return view('super.admin-detail', compact('departemen', 'admins'));
    }

    /**
     * Show edit form for an admin.
     */
    public function edit($admin_id)
    {
        $admin = User::where('role', 'admin')->findOrFail($admin_id);
        $departments = Departemen::orderBy('nama_departemen')->get();

        return view('super.admin-edit', compact('admin', 'departments'));
    }

    /**
     * Update admin details.
     */
    public function update(Request $request, $admin_id)
    {
        $admin = User::where('role', 'admin')->findOrFail($admin_id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin_id,
            'id_departemen' => 'nullable|exists:departemens,id',
        ]);

        $admin->update($data);

        return redirect()->route('super.admin-detail.show', $admin->id_departemen ?? 1)
            ->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Delete an admin.
     */
    public function destroy($admin_id)
    {
        $admin = User::where('role', 'admin')->findOrFail($admin_id);
        $departemen_id = $admin->id_departemen;

        $admin->delete();

        return redirect()->route('super.admin-detail.show', $departemen_id ?? 1)
            ->with('success', 'Admin berhasil dihapus.');
    }
}
