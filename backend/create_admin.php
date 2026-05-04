<?php

// Quick script to create admin user
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@test.com',
    'password' => bcrypt('password123'),
    'role' => 'admin'
]);

echo "✅ Admin user created!\n";
echo "Email: admin@test.com\n";
echo "Password: password123\n";
echo "ID: {$user->id}\n";
