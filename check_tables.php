<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\Schema;

echo "Badges Table: " . (Schema::hasTable('badges') ? 'Exists' : 'Missing') . "\n";
echo "User Badges Table: " . (Schema::hasTable('user_badges') ? 'Exists' : 'Missing') . "\n";
echo "Users Points Column: " . (Schema::hasColumn('users', 'points') ? 'Exists' : 'Missing') . "\n";
