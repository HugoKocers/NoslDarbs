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

        \Log::info('Game end request', [
            'user_id' => $user->id,
            'request_data' => $request->all()
        ]);

        $validated = $request->validate([
            'points' => 'required|integer|min:0',
            'cards_flipped' => 'required|integer|min:0',
            'game_mode' => 'nullable|string',
            'flipped_card_ids' => 'nullable|array',
            'flipped_card_ids.*' => 'integer'
        ]);

        // Set default game_mode
        $validated['game_mode'] = $validated['game_mode'] ?? 'rng';

        \Log::info('Validation passed', [
            'validated' => $validated
        ]);

        // Update user's total experience/points
        $user->increment('experience', $validated['points']);

        // Calculate level based on experience (every 500 points = 1 level)
        $user->level = (int) ceil($user->experience / 500);
        $user->save();

        \Log::info('User updated', [
            'user_id' => $user->id,
            'experience' => $user->experience,
            'level' => $user->level
        ]);

        // Mark flipped cards as unlocked (seen)
        $cardsUnlocked = 0;
        if (isset($validated['flipped_card_ids']) && is_array($validated['flipped_card_ids'])) {
            \Log::info('Unlocking cards', [
                'count' => count($validated['flipped_card_ids']),
                'card_ids' => $validated['flipped_card_ids']
            ]);
            
            foreach ($validated['flipped_card_ids'] as $cardId) {
                try {
                    \App\Models\UserCard::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'card_id' => (int) $cardId
                        ],
                        [
                            'quantity' => 1,
                            'unlocked_at' => now()
                        ]
                    );
                    $cardsUnlocked++;
                    \Log::info('Card unlocked', [
                        'user_id' => $user->id,
                        'card_id' => $cardId
                    ]);
                } catch (\Exception $e) {
                    // Log error but don't fail the entire game save
                    \Log::error('Failed to unlock card: ' . $e->getMessage(), [
                        'user_id' => $user->id,
                        'card_id' => $cardId,
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        } else {
            \Log::warning('No cards to unlock', [
                'user_id' => $user->id,
                'flipped_card_ids' => $validated['flipped_card_ids'] ?? 'not set'
            ]);
        }

        \Log::info('Cards unlocked', [
            'total' => $cardsUnlocked
        ]);

        // Log game record for history/leaderboard
        \App\Models\GameRecord::create([
            'user_id' => $user->id,
            'points' => $validated['points'],
            'cards_flipped' => $validated['cards_flipped'],
            'game_mode' => $validated['game_mode'],
            'date' => now()
        ]);

        // Refresh user to get latest data
        $user->refresh();
        
        // Get updated stats
        $gameRecords = $user->gameRecords;
        $totalGames = $gameRecords->count();
        $averageScore = $totalGames > 0 ? round($gameRecords->avg('points'), 2) : 0;
        $highestScore = $totalGames > 0 ? $gameRecords->max('points') : 0;
        $cardsUnlocked = \App\Models\UserCard::where('user_id', $user->id)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Game saved successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'experience' => $user->experience,
                'level' => $user->level
            ],
            'stats' => [
                'total_games' => $totalGames,
                'total_points' => $user->experience,
                'average_score' => $averageScore,
                'highest_score' => $highestScore,
                'cards_unlocked' => $cardsUnlocked
            ],
            'game_result' => [
                'points' => $validated['points'],
                'cards_flipped' => $validated['cards_flipped'],
                'game_mode' => $validated['game_mode']
            ]
        ]);
    }

    /**
     * Get user's card collection with unlock status (based on cards seen in games)
     */
    public function collection(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get all cards
        $allCards = \App\Models\Card::all();
        
        // Get user's unlocked cards (cards they've seen)
        $userCards = \App\Models\UserCard::where('user_id', $user->id)
            ->pluck('card_id')
            ->toArray();

        // Map cards with unlock status
        $collection = $allCards->map(function ($card) use ($userCards) {
            $isUnlocked = in_array($card->id, $userCards);

            return [
                'id' => $card->id,
                'name' => $card->name,
                'element' => $card->element,
                'rarity' => $card->rarity,
                'image_url' => $card->image_url,
                'unlocked' => $isUnlocked
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

        // Get cards unlocked count
        $cardsUnlocked = \App\Models\UserCard::where('user_id', $user->id)->count();

        return response()->json([
            'status' => 'success',
            'stats' => [
                'total_games' => $totalGames,
                'total_points' => $user->experience,
                'average_score' => $averageScore,
                'highest_score' => $highestScore,
                'level' => $user->level,
                'experience' => $user->experience,
                'cards_unlocked' => $cardsUnlocked
            ]
        ]);
    }

    /**
     * Get global leaderboard (excludes admin users)
     */
    public function leaderboard(Request $request)
    {
        $limit = $request->query('limit', 10);

        // Get top players by experience (excluding admins)
        $leaderboard = \App\Models\User::where('role', '!=', 'admin')
            ->orderBy('experience', 'desc')
            ->limit($limit)
            ->select('id', 'name', 'level', 'experience')
            ->get();

        return response()->json([
            'status' => 'success',
            'leaderboard' => $leaderboard
        ]);
    }
}
