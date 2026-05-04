<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Get all users
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'level', 'experience', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    /**
     * Get a specific user with details
     */
    public function show(User $user)
    {
        $user->load(['userCards', 'decks', 'gameRecords']);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|string|in:user,admin'
        ]);

        $user->update(['role' => $validated['role']]);

        return response()->json([
            'status' => 'success',
            'message' => 'User role updated successfully',
            'data' => $user
        ]);
    }

    /**
     * Delete a user and their associated data
     */
    public function destroy(User $user)
    {
        // Delete user's cards, decks, and game records
        $user->userCards()->delete();
        $user->decks()->delete();
        $user->gameRecords()->delete();
        
        // Delete the user
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Get system statistics
     */
    public function getStats()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $totalCards = \App\Models\Card::count();
        $totalBattles = \App\Models\Battle::count();
        $avgCardPower = \App\Models\Card::avg('power');

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_users' => $totalUsers,
                'admin_users' => $adminCount,
                'total_cards' => $totalCards,
                'total_battles' => $totalBattles,
                'avg_card_power' => round($avgCardPower, 1)
            ]
        ]);
    }
}
