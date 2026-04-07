<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Start a new game session
     */
    public function start(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Generate 12 random cards in the session
        $cards = range(1, 12);
        
        return response()->json([
            'status' => 'success',
            'game' => [
                'id' => uniqid('game_'),
                'cards' => $cards,
                'total_cards' => 12
            ]
        ]);
    }

    /**
     * End game and save results (points, cards flipped, etc.)
     */
    public function end(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'points' => 'required|integer|min:0',
            'cards_flipped' => 'required|integer|min:0|max:12',
            'game_mode' => 'string|default:rng',
            'flipped_card_ids' => 'nullable|array',
            'flipped_card_ids.*' => 'integer|exists:cards,id'
        ]);

        $totalPoints = $validated['points'];
        $unlockedCards = [];

        // Process card unlocks if card IDs were provided
        if (!empty($validated['flipped_card_ids'])) {
            foreach ($validated['flipped_card_ids'] as $cardId) {
                $card = \App\Models\Card::find($cardId);
                if ($card) {
                    // Check if card already exists in user_cards (dupe detection)
                    $existingCard = \App\Models\UserCard::where('user_id', $user->id)
                        ->where('card_id', $cardId)
                        ->first();

                    if (!$existingCard) {
                        // New card unlock - calculate rarity bonus
                        $rarityBonus = $this->calculateRarityBonus($card->rarity);
                        $totalPoints += $rarityBonus;

                        // Save new unlock
                        \App\Models\UserCard::create([
                            'user_id' => $user->id,
                            'card_id' => $cardId,
                            'quantity' => 1,
                            'unlocked_at' => now()
                        ]);

                        $unlockedCards[] = [
                            'card_id' => $cardId,
                            'name' => $card->name,
                            'rarity' => $card->rarity,
                            'bonus' => $rarityBonus
                        ];
                    } else {
                        // Dupe - increment quantity but no bonus points
                        $existingCard->increment('quantity');
                    }
                }
            }
        }

        // Update user's total experience/points
        $user->increment('experience', $totalPoints);

        // Calculate level based on experience (every 500 points = 1 level)
        $user->level = (int) ceil($user->experience / 500);
        $user->save();

        // Log game record for history/leaderboard
        \App\Models\GameRecord::create([
            'user_id' => $user->id,
            'points' => $totalPoints,
            'cards_flipped' => $validated['cards_flipped'],
            'game_mode' => $validated['game_mode'],
            'date' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Game saved successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'experience' => $user->experience,
                'level' => $user->level
            ],
            'game_result' => [
                'points' => $validated['points'],
                'cards_flipped' => $validated['cards_flipped'],
                'total_points' => $totalPoints,
                'unlocked_cards' => $unlockedCards,
                'game_mode' => $validated['game_mode']
            ]
        ]);
    }

    /**
     * Get user's card collection with unlock status
     */
    public function collection(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get all cards
        $allCards = \App\Models\Card::all();
        
        // Get user's unlocked cards
        $userCards = \App\Models\UserCard::where('user_id', $user->id)
            ->pluck('card_id')
            ->toArray();

        // Map cards with unlock status
        $collection = $allCards->map(function ($card) use ($userCards) {
            $isUnlocked = in_array($card->id, $userCards);
            $userCard = $isUnlocked ? \App\Models\UserCard::where('user_id', auth()->id())
                ->where('card_id', $card->id)
                ->first() : null;

            return [
                'id' => $card->id,
                'name' => $card->name,
                'description' => $card->description,
                'power' => $card->power,
                'cost' => $card->cost,
                'element' => $card->element,
                'rarity' => $card->rarity,
                'image_url' => $card->image_url,
                'unlocked' => $isUnlocked,
                'unlocked_at' => $userCard?->unlocked_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'total_cards' => $allCards->count(),
            'unlocked_count' => count($userCards),
            'collection' => $collection
        ]);
    }

    /**
     * Calculate rarity-based unlock bonus points
     */
    private function calculateRarityBonus(string $rarity): int
    {
        $rarityBonuses = [
            'common' => 5,
            'uncommon' => 15,
            'rare' => 30,
            'epic' => 50,
            'legendary' => 100
        ];

        return $rarityBonuses[strtolower($rarity)] ?? 0;
    }

    /**
     * Get game statistics for current user
     */
    public function stats(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get total games played and average score
        $gameRecords = $user->gameRecords;
        
        $totalGames = $gameRecords->count();
        $averageScore = $totalGames > 0 ? round($gameRecords->avg('points'), 2) : 0;
        $highestScore = $totalGames > 0 ? $gameRecords->max('points') : 0;

        return response()->json([
            'status' => 'success',
            'stats' => [
                'total_games' => $totalGames,
                'total_points' => $user->experience,
                'average_score' => $averageScore,
                'highest_score' => $highestScore,
                'level' => $user->level,
                'experience' => $user->experience
            ]
        ]);
    }
}
