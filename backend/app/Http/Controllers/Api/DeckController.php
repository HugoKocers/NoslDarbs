<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    /**
     * Get all user decks
     */
    public function index(Request $request)
    {
        $decks = $request->user()->decks()->with('cards')->get();
        return response()->json($decks);
    }

    /**
     * Create a new deck
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $deck = $request->user()->decks()->create($validated);
        return response()->json($deck, 201);
    }

    /**
     * Get a single deck
     */
    public function show(Deck $deck)
    {
        $this->authorize('view', $deck);
        return response()->json($deck->load('cards'));
    }

    /**
     * Update a deck
     */
    public function update(Request $request, Deck $deck)
    {
        $this->authorize('update', $deck);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
        ]);

        $deck->update($validated);
        return response()->json($deck);
    }

    /**
     * Delete a deck
     */
    public function destroy(Deck $deck)
    {
        $this->authorize('delete', $deck);
        $deck->delete();
        return response()->json(null, 204);
    }
}
