<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'power',
        'cost',
        'element',
        'rarity',
        'image_url',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_cards')->withTimestamps();
    }

    public function decks()
    {
        return $this->belongsToMany(Deck::class, 'deck_cards')->withTimestamps();
    }
}
