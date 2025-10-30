<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// bootstrap kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pegawai;
use App\Models\User;

$p = Pegawai::latest('created_at')->first();
if (! $p) {
    echo "NO_PEG\n";
    exit(0);
}

// generate password
$newpass = substr(bin2hex(random_bytes(8)), 0, 12);

$u = User::where('name', $p->nama_pegawai)->first();
if ($u) {
    $u->password = $newpass; // cast will hash
    $u->id_departemen = $p->id_departemen ?? $u->id_departemen;
    $u->save();
    echo "UPDATED|{$u->email}|{$u->name}|{$newpass}\n";
} else {
    $email = $p->nik_pegawai ? $p->nik_pegawai . '@example.com' : strtolower(preg_replace('/\s+/', '', $p->nama_pegawai)) . '@example.com';
    $u = User::create([
        'name' => $p->nama_pegawai,
        'email' => $email,
        'password' => $newpass,
        'role' => 'user',
        'id_departemen' => $p->id_departemen ?? null,
    ]);
    echo "CREATED|{$u->email}|{$u->name}|{$newpass}\n";
}
