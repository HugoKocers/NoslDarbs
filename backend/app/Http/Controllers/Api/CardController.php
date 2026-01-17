<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Get all cards with pagination
     */
    public function index(Request $request)
    {
        $cards = Card::paginate($request->get('per_page', 15));
        return response()->json($cards);
    }

    /**
     * Get a single card
     */
    public function show($id)
    {
        $card = Card::findOrFail($id);
        return response()->json($card);
    }

    /**
     * Get user's cards
     */
    public function getUserCards(Request $request)
    {
        $user = $request->user();
        $cards = $user->cards()->paginate($request->get('per_page', 15));
        return response()->json($cards);
    }
}
