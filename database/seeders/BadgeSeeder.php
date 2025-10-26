<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Newbie',
                'slug' => 'newbie',
                'description' => 'Just getting started on the platform',
                'icon' => '🥉',
                'color' => '#cd7f32',
                'min_points' => 0,
                'max_points' => 500,
                'level' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Intermediate',
                'slug' => 'intermediate',
                'description' => 'Making progress and gaining experience',
                'icon' => '🥈',
                'color' => '#c0c0c0',
                'min_points' => 501,
                'max_points' => 1500,
                'level' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Expert',
                'slug' => 'expert',
                'description' => 'Highly skilled and knowledgeable author',
                'icon' => '🥇',
                'color' => '#ffd700',
                'min_points' => 1501,
                'max_points' => 4000,
                'level' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Influencer',
                'slug' => 'influencer',
                'description' => 'Top-tier author with massive influence',
                'icon' => '💎',
                'color' => '#b9f2ff',
                'min_points' => 4001,
                'max_points' => null,
                'level' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::firstOrCreate(
                ['slug' => $badge['slug']],
                $badge
            );
        }
    }
}