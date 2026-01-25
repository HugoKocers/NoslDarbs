<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            // Fire element cards
            ['name' => 'Fireball', 'description' => 'Deals fire damage to enemy', 'power' => 8, 'cost' => 4, 'element' => 'fire', 'rarity' => 'common', 'image_url' => 'https://via.placeholder.com/150/FF5733/FFFFFF?text=Fireball'],
            ['name' => 'Inferno Dragon', 'description' => 'Powerful fire dragon', 'power' => 12, 'cost' => 7, 'element' => 'fire', 'rarity' => 'rare', 'image_url' => 'https://via.placeholder.com/150/FF5733/FFFFFF?text=Inferno+Dragon'],
            ['name' => 'Flame Strike', 'description' => 'Quick fire attack', 'power' => 6, 'cost' => 3, 'element' => 'fire', 'rarity' => 'common', 'image_url' => 'https://via.placeholder.com/150/FF5733/FFFFFF?text=Flame+Strike'],
            ['name' => 'Lava Golem', 'description' => 'Tanky fire creature', 'power' => 9, 'cost' => 5, 'element' => 'fire', 'rarity' => 'rare', 'image_url' => 'https://via.placeholder.com/150/FF5733/FFFFFF?text=Lava+Golem'],
            
            // Water element cards
            ['name' => 'Ice Shard', 'description' => 'Freezes enemy for 1 turn', 'power' => 5, 'cost' => 2, 'element' => 'water', 'rarity' => 'common', 'image_url' => 'https://via.placeholder.com/150/3399FF/FFFFFF?text=Ice+Shard'],
            ['name' => 'Tsunami', 'description' => 'Massive water attack', 'power' => 11, 'cost' => 6, 'element' => 'water', 'rarity' => 'rare', 'image_url' => 'https://via.placeholder.com/150/3399FF/FFFFFF?text=Tsunami'],
            ['name' => 'Frost Nova', 'description' => 'AoE ice damage', 'power' => 7, 'cost' => 4, 'element' => 'water', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/3399FF/FFFFFF?text=Frost+Nova'],
            ['name' => 'Water Elemental', 'description' => 'Healing water creature', 'power' => 6, 'cost' => 3, 'element' => 'water', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/3399FF/FFFFFF?text=Water+Elemental'],
            
            // Nature element cards
            ['name' => 'Forest Guardian', 'description' => 'Protects your deck', 'power' => 8, 'cost' => 4, 'element' => 'nature', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/33CC33/FFFFFF?text=Forest+Guardian'],
            ['name' => 'Thorns', 'description' => 'Reflects damage', 'power' => 4, 'cost' => 2, 'element' => 'nature', 'rarity' => 'common', 'image_url' => 'https://via.placeholder.com/150/33CC33/FFFFFF?text=Thorns'],
            ['name' => 'Ancient Tree', 'description' => 'Regenerates health', 'power' => 5, 'cost' => 4, 'element' => 'nature', 'rarity' => 'rare', 'image_url' => 'https://via.placeholder.com/150/33CC33/FFFFFF?text=Ancient+Tree'],
            ['name' => 'Summon Wolves', 'description' => 'Creates 2 wolf tokens', 'power' => 7, 'cost' => 5, 'element' => 'nature', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/33CC33/FFFFFF?text=Summon+Wolves'],
            
            // Lightning element cards
            ['name' => 'Thunderbolt', 'description' => 'Direct lightning strike', 'power' => 9, 'cost' => 4, 'element' => 'lightning', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/FFFF33/000000?text=Thunderbolt'],
            ['name' => 'Electric Dragon', 'description' => 'Stuns enemies', 'power' => 10, 'cost' => 6, 'element' => 'lightning', 'rarity' => 'rare', 'image_url' => 'https://via.placeholder.com/150/FFFF33/000000?text=Electric+Dragon'],
            ['name' => 'Chain Lightning', 'description' => 'Hits multiple targets', 'power' => 8, 'cost' => 5, 'element' => 'lightning', 'rarity' => 'rare', 'image_url' => 'https://via.placeholder.com/150/FFFF33/000000?text=Chain+Lightning'],
            ['name' => 'Static Field', 'description' => 'Prevents spell cast', 'power' => 6, 'cost' => 3, 'element' => 'lightning', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/FFFF33/000000?text=Static+Field'],
            
            // Dark element cards
            ['name' => 'Shadow Bolt', 'description' => 'Dark energy attack', 'power' => 8, 'cost' => 4, 'element' => 'dark', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/663399/FFFFFF?text=Shadow+Bolt'],
            ['name' => 'Necromancer', 'description' => 'Raises undead minions', 'power' => 9, 'cost' => 6, 'element' => 'dark', 'rarity' => 'rare', 'image_url' => 'https://via.placeholder.com/150/663399/FFFFFF?text=Necromancer'],
            ['name' => 'Curse', 'description' => 'Weakens enemy', 'power' => 5, 'cost' => 2, 'element' => 'dark', 'rarity' => 'common', 'image_url' => 'https://via.placeholder.com/150/663399/FFFFFF?text=Curse'],
            ['name' => 'Dark Ritual', 'description' => 'Sacrifice for power', 'power' => 7, 'cost' => 3, 'element' => 'dark', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/663399/FFFFFF?text=Dark+Ritual'],
            
            // Light element cards
            ['name' => 'Holy Light', 'description' => 'Heals allies', 'power' => 6, 'cost' => 3, 'element' => 'light', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/FFFF99/000000?text=Holy+Light'],
            ['name' => 'Angel Guardian', 'description' => 'Protective light creature', 'power' => 8, 'cost' => 5, 'element' => 'light', 'rarity' => 'rare', 'image_url' => 'https://via.placeholder.com/150/FFFF99/000000?text=Angel+Guardian'],
            ['name' => 'Divine Strike', 'description' => 'Blessed attack', 'power' => 7, 'cost' => 4, 'element' => 'light', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/FFFF99/000000?text=Divine+Strike'],
            ['name' => 'Sanctuary', 'description' => 'Protected zone', 'power' => 5, 'cost' => 4, 'element' => 'light', 'rarity' => 'rare', 'image_url' => 'https://via.placeholder.com/150/FFFF99/000000?text=Sanctuary'],
            
            // Neutral cards
            ['name' => 'Sword Warrior', 'description' => 'Basic melee fighter', 'power' => 5, 'cost' => 2, 'element' => 'neutral', 'rarity' => 'common', 'image_url' => 'https://via.placeholder.com/150/999999/FFFFFF?text=Sword+Warrior'],
            ['name' => 'Knight of Valor', 'description' => 'Strong defender', 'power' => 8, 'cost' => 4, 'element' => 'neutral', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/999999/FFFFFF?text=Knight'],
            ['name' => 'Legendary Hero', 'description' => 'Most powerful card', 'power' => 15, 'cost' => 10, 'element' => 'neutral', 'rarity' => 'legendary', 'image_url' => 'https://via.placeholder.com/150/FFD700/000000?text=Legendary+Hero'],
            ['name' => 'Archer', 'description' => 'Ranged attacker', 'power' => 6, 'cost' => 2, 'element' => 'neutral', 'rarity' => 'common', 'image_url' => 'https://via.placeholder.com/150/999999/FFFFFF?text=Archer'],
            ['name' => 'Mercenary', 'description' => 'For hire fighter', 'power' => 7, 'cost' => 3, 'element' => 'neutral', 'rarity' => 'uncommon', 'image_url' => 'https://via.placeholder.com/150/999999/FFFFFF?text=Mercenary'],
        ];

        foreach ($cards as $card) {
            Card::create($card);
        }
    }
}
