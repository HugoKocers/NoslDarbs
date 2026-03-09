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
            'game_mode' => 'string|default:rng'
        ]);

        // Update user's total experience/points
        $user->increment('experience', $validated['points']);

        // Calculate level based on experience (every 500 points = 1 level)
        $user->level = (int) ceil(($user->experience + $validated['points']) / 500);
        $user->save();

        // Log game record for history/leaderboard
        \App\Models\GameRecord::create([
            'user_id' => $user->id,
            'points' => $validated['points'],
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
            'game_result' => $validated
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
