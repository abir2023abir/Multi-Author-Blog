<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poll;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing polls
        Poll::truncate();

        // Create polls matching the image
        Poll::create([
            'question' => 'Do you like reading in the subway?',
            'language' => 'en',
            'vote_permission' => 'all',
            'options' => ['Yes', 'No', 'Sometimes'],
            'is_active' => true,
            'closes_at' => now()->addDays(30),
            'date_added' => now()->subHours(2),
        ]);

        Poll::create([
            'question' => 'What is your favorite color?',
            'language' => 'en',
            'vote_permission' => 'all',
            'options' => ['Red', 'Blue', 'Green', 'Yellow', 'Purple'],
            'is_active' => true,
            'closes_at' => now()->addDays(30),
            'date_added' => now()->subHours(1),
        ]);

        Poll::create([
            'question' => 'ما هو لونك المفضل؟',
            'language' => 'ar',
            'vote_permission' => 'all',
            'options' => ['أحمر', 'أزرق', 'أخضر', 'أصفر', 'بنفسجي'],
            'is_active' => true,
            'closes_at' => now()->addDays(30),
            'date_added' => now()->subMinutes(30),
        ]);
    }
}