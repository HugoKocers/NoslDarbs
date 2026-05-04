<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CardSeeder::class);

        \App\Models\User::factory()->create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    }
}
