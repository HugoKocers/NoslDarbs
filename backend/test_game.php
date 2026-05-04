<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\UserCard;

$user = User::find(1);
echo "User: " . $user->name . "\n";
echo "Experience: " . $user->experience . "\n";
echo "Level: " . $user->level . "\n";

$userCards = UserCard::where('user_id', 1)->get();
echo "Unlocked cards: " . $userCards->count() . "\n";

foreach ($userCards as $card) {
    echo "  - Card ID: " . $card->card_id . " (unlocked at: " . $card->unlocked_at . ")\n";
}
?>
