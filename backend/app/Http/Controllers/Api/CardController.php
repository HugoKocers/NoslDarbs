<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\UserCard;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::paginate(20);
        return response()->json($cards);
    }

    public function show($id)
    {
        $card = Card::findOrFail($id);
        return response()->json($card);
    }

    public function getUserCards(Request $request)
    {
        $userCards = $request->user()
            ->userCards()
            ->with('card')
            ->paginate(20);

        return response()->json($userCards);
    }

    public function addCard(Request $request)
    {
        $validated = $request->validate([
            'card_id' => 'required|exists:cards,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userCard = UserCard::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'card_id' => $validated['card_id'],
            ],
            [
                'quantity' => $validated['quantity'],
            ]
        );

        return response()->json([
            'message' => 'Card added successfully',
            'user_card' => $userCard,
        ]);
    }
}
