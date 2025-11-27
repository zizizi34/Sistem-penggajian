<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;

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

// Absensi (user)
Route::middleware(['auth'])->group(function () {
    Route::get('/absensi', [\App\Http\Controllers\AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [\App\Http\Controllers\AbsensiController::class, 'store'])->name('absensi.store');
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

        // Fetch admin data
        $admins = \App\Models\User::where('role', 'admin')->with('departemen')->orderBy('created_at', 'desc')->get();
        $totalAdmins = $admins->count();
        $departments = \App\Models\Departemen::withCount(['admins', 'pegawais'])->get();

        return view('super.dashboard', compact('totalUsers', 'totalPegawai', 'totalDepartments', 'totalPenggajian', 'departments', 'activities', 'admins', 'totalAdmins'));
    })->name('super.dashboard');
    
        // Super admin: manage admins
        Route::get('/super/admins/create', [\App\Http\Controllers\Super\AdminController::class, 'create'])->name('super.admins.create');
        Route::post('/super/admins', [\App\Http\Controllers\Super\AdminController::class, 'store'])->name('super.admins.store');
});

// Admin
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin', \App\Http\Middleware\EnsureAdminDepartment::class])->group(function () {
    Route::get('/admin/dashboard', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();

        // For admin, enforce their department
        $deptId = $user->id_departemen ?? $request->query('dept');

        // Departments list (for supervisors or UI; admin will only see their dept)
        $departments = \App\Models\Departemen::orderBy('nama_departemen')->get();

        $selectedDept = $deptId ? \App\Models\Departemen::find($deptId) : null;

        // List pegawai for that department
        $pegawais = [];
        $totalPegawai = 0;
        $totalPenggajian = 0;
        if ($selectedDept) {
            $pegawais = \App\Models\Pegawai::where('id_departemen', $selectedDept->id)->get();
            $totalPegawai = $pegawais->count();
            $totalPenggajian = \App\Models\Penggajian::where('id_departemen', $selectedDept->id)->count();
        }

        return view('admin.dashboard', compact('departments', 'selectedDept', 'totalPegawai', 'totalPenggajian', 'pegawais'));
    })->name('admin.dashboard');

    // Pegawai management for admins
    // GET /pegawai is provided so links or redirects that request the index via GET don't hit the POST-only route.
    Route::get('/pegawai', [\App\Http\Controllers\PegawaiController::class, 'index'])->name('pegawai.index');
    // creation is still via modal (POST)
    Route::post('/pegawai', [\App\Http\Controllers\PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{id}/edit', [\App\Http\Controllers\PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{id}', [\App\Http\Controllers\PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{id}', [\App\Http\Controllers\PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    // Jadwal routes
    Route::get('/pegawai/{id}/jadwal', [\App\Http\Controllers\JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/pegawai/{id}/jadwal', [\App\Http\Controllers\JadwalController::class, 'store'])->name('jadwal.store');
    Route::delete('/pegawai/{id}/jadwal/{jadwal}', [\App\Http\Controllers\JadwalController::class, 'destroy'])->name('jadwal.destroy');
});

// User
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/user/dashboard', function () {
        $user = auth()->user();

        // show the last 14 days (including today)
        $days = [];
        $start = \Illuminate\Support\Carbon::now()->subDays(13)->startOfDay();
        for ($d = 0; $d < 14; $d++) {
            $date = $start->copy()->addDays($d);
            $days[] = $date;
        }

        $absensis = \App\Models\Absensi::where('user_id', $user->id)
            ->whereBetween('waktu', [\Illuminate\Support\Carbon::now()->subDays(13)->startOfDay(), \Illuminate\Support\Carbon::now()->endOfDay()])
            ->orderBy('waktu')
            ->get();

        // Build per-day summary
        $summary = collect();
        foreach ($days as $day) {
            $records = $absensis->filter(function ($a) use ($day) {
                return \Illuminate\Support\Carbon::parse($a->waktu)->isSameDay($day);
            });

            $status = 'Tidak Hadir';
            if ($records->contains(function ($r) { return $r->jenis === 'masuk'; })) {
                $status = 'Hadir';
            } elseif ($records->contains(function ($r) { return strtolower(trim($r->keterangan ?? '')) === 'izin' || ($r->jenis ?? '') === 'izin'; })) {
                $status = 'Izin';
            }

            // clock-in and clock-out times (first masuk, last keluar)
            $masuk = $records->firstWhere('jenis', 'masuk');
            // Collection::lastWhere isn't available in this Laravel version; use where() + last()
            $keluar = $records->where('jenis', 'keluar')->last();

            $summary->push([
                'date' => $day->toDateString(),
                'pretty' => $day->translatedFormat('d M Y (D)'),
                'status' => $status,
                'masuk' => $masuk ? \Illuminate\Support\Carbon::parse($masuk->waktu)->format('H:i') : null,
                'keluar' => $keluar ? \Illuminate\Support\Carbon::parse($keluar->waktu)->format('H:i') : null,
                'records' => $records,
            ]);
        }

        // Totals
        $totals = [
            'Hadir' => $summary->where('status', 'Hadir')->count(),
            'Izin' => $summary->where('status', 'Izin')->count(),
            'Tidak Hadir' => $summary->where('status', 'Tidak Hadir')->count(),
        ];

        return view('user.dashboard', compact('summary', 'totals'));
    })->name('user.dashboard');
});

require __DIR__.'/auth.php';
    