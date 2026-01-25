<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deck_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deck_id')->constrained('decks')->onDelete('cascade');
            $table->foreignId('card_id')->constrained('cards')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
            $table->unique(['deck_id', 'card_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deck_cards');
    }
};
