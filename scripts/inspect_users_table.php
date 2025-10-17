<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$columns = DB::select("SHOW COLUMNS FROM users");
foreach ($columns as $c) {
    echo $c->Field . '|' . $c->Type . "\n";
}

echo "--- admins ---\n";
$admins = DB::table('users')->where('role','admin')->get();
foreach($admins as $a) {
    foreach((array)$a as $k=>$v) echo $k . ':' . $v . '|';
    echo "\n";
}
