<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class AdminCardController extends Controller
{
    /**
     * Get all cards (admin view with full details)
     */
    public function index()
    {
        $cards = Card::all();
        return response()->json([
            'status' => 'success',
            'data' => $cards
        ]);
    }

    /**
     * Store a new card
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'power' => 'required|integer|min:1|max:100',
            'cost' => 'nullable|integer|min:0',
            'element' => 'required|string|in:Fire,Water,Nature,Lightning,Dark,Light',
            'rarity' => 'required|string|in:Common,Uncommon,Rare,Epic,Legendary',
            'image_url' => 'nullable|url'
        ]);

        $card = Card::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Card created successfully',
            'data' => $card
        ], 201);
    }

    /**
     * Get a specific card
     */
    public function show(Card $card)
    {
        return response()->json([
            'status' => 'success',
            'data' => $card
        ]);
    }

    /**
     * Update a card
     */
    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'power' => 'sometimes|integer|min:1|max:100',
            'cost' => 'nullable|integer|min:0',
            'element' => 'sometimes|string|in:Fire,Water,Nature,Lightning,Dark,Light',
            'rarity' => 'sometimes|string|in:Common,Uncommon,Rare,Epic,Legendary',
            'image_url' => 'nullable|url'
        ]);

        $card->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Card updated successfully',
            'data' => $card
        ]);
    }

    /**
     * Delete a card
     */
    public function destroy(Card $card)
    {
        $card->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Card deleted successfully'
        ]);
    }
}
