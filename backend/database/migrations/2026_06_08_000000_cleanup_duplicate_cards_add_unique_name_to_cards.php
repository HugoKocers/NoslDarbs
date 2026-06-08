<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $cards = DB::table('cards')
                ->select('id', 'name', 'element', 'rarity', 'image_url')
                ->get();

            $groups = [];
            foreach ($cards as $card) {
                $normalizedName = trim(strtolower($card->name));
                if ($normalizedName === '') {
                    continue;
                }
                $groups[$normalizedName][] = $card;
            }

            foreach ($groups as $normalizedName => $group) {
                if (count($group) < 2) {
                    continue;
                }

                $signatureGroups = [];
                foreach ($group as $card) {
                    $signature = trim(strtolower($card->element)) . '|' . trim(strtolower($card->rarity)) . '|' . trim((string) $card->image_url);
                    $signatureGroups[$signature][] = $card;
                }

                foreach ($signatureGroups as $signature => $duplicateCards) {
                    if (count($duplicateCards) < 2) {
                        continue;
                    }

                    $keepCard = array_shift($duplicateCards);
                    $keepId = $keepCard->id;
                    $duplicateIds = array_map(fn($duplicate) => $duplicate->id, $duplicateCards);

                    foreach ($duplicateIds as $duplicateId) {
                        $duplicateUserCards = DB::table('user_cards')
                            ->where('card_id', $duplicateId)
                            ->get();

                        foreach ($duplicateUserCards as $userCard) {
                            $exists = DB::table('user_cards')
                                ->where('user_id', $userCard->user_id)
                                ->where('card_id', $keepId)
                                ->exists();

                            if ($exists) {
                                DB::table('user_cards')->where('id', $userCard->id)->delete();
                            } else {
                                DB::table('user_cards')->where('id', $userCard->id)->update(['card_id' => $keepId]);
                            }
                        }

                        $duplicateDeckCards = DB::table('deck_cards')
                            ->where('card_id', $duplicateId)
                            ->get();

                        foreach ($duplicateDeckCards as $deckCard) {
                            $exists = DB::table('deck_cards')
                                ->where('deck_id', $deckCard->deck_id)
                                ->where('card_id', $keepId)
                                ->exists();

                            if ($exists) {
                                DB::table('deck_cards')->where('id', $deckCard->id)->delete();
                            } else {
                                DB::table('deck_cards')->where('id', $deckCard->id)->update(['card_id' => $keepId]);
                            }
                        }
                    }

                    DB::table('cards')->whereIn('id', $duplicateIds)->delete();
                }
            }
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropUnique('cards_name_unique');
        });
    }
};
