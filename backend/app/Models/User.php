<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'experience',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function cards()
    {
        return $this->belongsToMany(Card::class, 'user_cards')->withTimestamps();
    }

    public function userCards()
    {
        return $this->hasMany(UserCard::class);
    }

    public function decks()
    {
        return $this->hasMany(Deck::class);
    }

    public function battlesAsPlayer1()
    {
        return $this->hasMany(Battle::class, 'player1_id');
    }

    public function battlesAsPlayer2()
    {
        return $this->hasMany(Battle::class, 'player2_id');
    }
}
