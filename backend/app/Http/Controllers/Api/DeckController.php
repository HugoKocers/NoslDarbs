<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use App\Models\DeckCard;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    public function index(Request $request)
    {
        $decks = $request->user()
            ->decks()
            ->with('cards')
            ->paginate(20);

        return response()->json($decks);
    }

    public function show(Request $request, $id)
    {
        $deck = Deck::where('user_id', $request->user()->id)
            ->findOrFail($id)
            ->load('cards');

        return response()->json($deck);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $deck = $request->user()->decks()->create($validated);

        return response()->json([
            'message' => 'Deck created successfully',
            'deck' => $deck,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $deck = Deck::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $deck->update($validated);

        return response()->json([
            'message' => 'Deck updated successfully',
            'deck' => $deck,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $deck = Deck::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $deck->delete();

        return response()->json([
            'message' => 'Deck deleted successfully',
        ]);
    }

    public function addCard(Request $request, $id)
    {
        $deck = Deck::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'card_id' => 'required|exists:cards,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $deckCard = DeckCard::updateOrCreate(
            [
                'deck_id' => $deck->id,
                'card_id' => $validated['card_id'],
            ],
            [
                'quantity' => $validated['quantity'],
            ]
        );

        return response()->json([
            'message' => 'Card added to deck successfully',
            'deck_card' => $deckCard,
        ]);
    }

    public function removeCard(Request $request, $id)
    {
        $deck = Deck::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'card_id' => 'required|exists:cards,id',
        ]);

        DeckCard::where('deck_id', $deck->id)
            ->where('card_id', $validated['card_id'])
            ->delete();

        return response()->json([
            'message' => 'Card removed from deck successfully',
        ]);
    }
}
