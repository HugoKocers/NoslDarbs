<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

$user = User::find(1);
$token = $user->createToken('test-token')->plainTextToken;

echo "Testing game/end endpoint...\n";
echo "Token: " . substr($token, 0, 20) . "...\n";

// Simulate a game end request
$gameData = [
    'points' => 150,
    'cards_flipped' => 6,
    'game_mode' => 'rng',
    'flipped_card_ids' => [1, 5, 12, 3, 7, 9]
];

echo "Game Data: " . json_encode($gameData, JSON_PRETTY_PRINT) . "\n\n";

// Make the request using Laravel's HTTP client directly
$response = \Illuminate\Support\Facades\Http::withToken($token)
    ->post('http://localhost:8000/api/game/end', $gameData);

echo "Response Status: " . $response->status() . "\n";
echo "Response Body: " . $response->body() . "\n";

// Check database
echo "\n--- Database Check ---\n";
$updatedUser = User::find(1);
echo "User Experience: " . $updatedUser->experience . "\n";

$userCards = \App\Models\UserCard::where('user_id', 1)->get();
echo "Unlocked Cards: " . $userCards->count() . "\n";
foreach ($userCards as $card) {
    echo "  - Card " . $card->card_id . ": " . $card->unlocked_at . "\n";
}
?>
