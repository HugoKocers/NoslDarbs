<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\DeckController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\AdminCardController;
use App\Http\Controllers\Api\AdminUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/cards', [CardController::class, 'index']);
Route::get('/cards/{id}', [CardController::class, 'show']);
Route::get('/leaderboard', [GameController::class, 'leaderboard']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Card routes
    Route::get('/user/cards', [CardController::class, 'getUserCards']);
    Route::get('/cards/random/game', [CardController::class, 'random']);

    // Deck routes
    Route::apiResource('decks', DeckController::class);

    // Game routes
    Route::post('/game/start', [GameController::class, 'start']);
    Route::post('/game/end', [GameController::class, 'end']);
    Route::get('/game/stats', [GameController::class, 'stats']);
    Route::get('/game/collection', [GameController::class, 'collection']);

    // Admin routes - protected by IsAdmin middleware
    Route::middleware('admin')->group(function () {
        // Admin Card management
        Route::get('/admin/cards', [AdminCardController::class, 'index']);
        Route::post('/admin/cards', [AdminCardController::class, 'store']);
        Route::get('/admin/cards/{card}', [AdminCardController::class, 'show']);
        Route::put('/admin/cards/{card}', [AdminCardController::class, 'update']);
        Route::delete('/admin/cards/{card}', [AdminCardController::class, 'destroy']);

        // Admin User management
        Route::get('/admin/users', [AdminUserController::class, 'index']);
        Route::get('/admin/users/{user}', [AdminUserController::class, 'show']);
        Route::put('/admin/users/{user}/role', [AdminUserController::class, 'updateRole']);
        Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy']);

        // System stats
        Route::get('/admin/stats', [AdminUserController::class, 'getStats']);
    });
});
