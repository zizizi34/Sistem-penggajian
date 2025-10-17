<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    // If user is not authenticated, show the normal dashboard view (or redirect to login handled by middleware)
    if (!$user) {
        return view('dashboard');
    }

    // Redirect role-specific dashboards. Super admins should not land on /dashboard.
    if ($user->role === 'super_admin') {
        return redirect()->route('super.dashboard');
    }

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // default for regular users
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Super Admin
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':super_admin'])->group(function () {
    Route::get('/super/dashboard', function () {
        $totalUsers = \App\Models\User::count();
        $totalPegawai = \App\Models\Pegawai::count();
        $totalDepartments = \App\Models\Departemen::count();
        $totalPenggajian = \App\Models\Penggajian::count();

        // Departments with pegawai counts
        $departments = \App\Models\Departemen::withCount('pegawais')->orderBy('nama_departemen')->get();

        // Build a simple recent activity feed from several models (creation timestamps)
        $activities = collect();

        $users = \App\Models\User::latest('created_at')->take(5)->get();
        foreach ($users as $u) {
            $activities->push([
                'time' => $u->created_at,
                'actor' => $u->email ?? $u->name,
                'action' => 'Pengguna dibuat',
                'note' => $u->role ?? '',
            ]);
        }

        $pegawais = \App\Models\Pegawai::latest('created_at')->take(5)->get();
        foreach ($pegawais as $p) {
            $activities->push([
                'time' => $p->created_at,
                'actor' => $p->nama_pegawai ?? 'Pegawai',
                'action' => 'Pegawai ditambahkan',
                'note' => optional($p->departemen)->nama_departemen ?? '',
            ]);
        }

        $penggajians = \App\Models\Penggajian::latest('created_at')->take(5)->get();
        foreach ($penggajians as $g) {
            $activities->push([
                'time' => $g->created_at ?? null,
                'actor' => 'Sistem',
                'action' => 'Penggajian diproses',
                'note' => 'ID: ' . ($g->id ?? '-'),
            ]);
        }

        $activities = $activities->sortByDesc('time')->take(10);

        return view('super.dashboard', compact('totalUsers', 'totalPegawai', 'totalDepartments', 'totalPenggajian', 'departments', 'activities'));
    })->name('super.dashboard');
    
        // Super admin: manage admins
        Route::get('/super/admins/create', [\App\Http\Controllers\Super\AdminController::class, 'create'])->name('super.admins.create');
        Route::post('/super/admins', [\App\Http\Controllers\Super\AdminController::class, 'store'])->name('super.admins.store');
});

// Admin
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', function (\Illuminate\Http\Request $request) {
        // Ambil daftar departemen untuk dipilih oleh admin
        $departments = \App\Models\Departemen::orderBy('nama_departemen')->get();

        // Jika admin memilih departemen (query param `dept`), tampilkan statistik untuk departemen itu
        $selectedDept = $request->query('dept');
        $totalPegawai = 0;
        $totalPenggajian = 0;

        if ($selectedDept) {
            $totalPegawai = \App\Models\Pegawai::where('id_departemen', $selectedDept)->count();
            $totalPenggajian = \App\Models\Penggajian::where('id_departemen', $selectedDept)->count();
        }

        return view('admin.dashboard', compact('departments', 'selectedDept', 'totalPegawai', 'totalPenggajian'));
    })->name('admin.dashboard');
});

// User
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

require __DIR__.'/auth.php';
    