<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$user = User::find(1);
$token = $user->createToken('test-token')->plainTextToken;
echo "Auth Token: " . $token . "\n";
?>
