<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SampleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Lisa Thompson',
                'email' => 'lisa@example.com',
                'password' => bcrypt('password'),
                'bio' => 'Food blogger and recipe developer sharing delicious creations',
                'avatar_url' => 'https://ui-avatars.com/api/?name=LT&background=random',
            ],
            [
                'name' => 'Emma Rodriguez',
                'email' => 'emma@example.com',
                'password' => bcrypt('password'),
                'bio' => 'Travel blogger exploring the world one destination at a time',
                'avatar_url' => 'https://ui-avatars.com/api/?name=ER&background=random',
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria@example.com',
                'password' => bcrypt('password'),
                'bio' => 'Fashion blogger and style influencer with a passion for sustainable fashion',
                'avatar_url' => 'https://ui-avatars.com/api/?name=MG&background=random',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'password' => bcrypt('password'),
                'bio' => 'Tech enthusiast and lifestyle blogger with 5+ years of experience',
                'avatar_url' => 'https://ui-avatars.com/api/?name=SJ&background=random',
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
