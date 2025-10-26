<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist
        foreach (['admin', 'writer', 'reader'] as $r) {
            Role::firstOrCreate(['name' => $r, 'guard_name' => 'web']);
        }

        // Users
        $admin = User::firstOrCreate(
            ['email' => 'saifultwilight20@gmail.com'],
            ['name' => 'Admin', 'password' => Hash::make('abir2025##2025'), 'role' => 'admin']
        );
        $writer = User::firstOrCreate(
            ['email' => 'writer@example.com'],
            ['name' => 'Writer', 'password' => Hash::make('password'), 'role' => 'writer']
        );
        $reader = User::firstOrCreate(
            ['email' => 'reader@example.com'],
            ['name' => 'Reader', 'password' => Hash::make('password'), 'role' => 'reader']
        );

        // Assign roles via Spatie
        $admin->syncRoles(['admin']);
        $writer->syncRoles(['writer']);
        $reader->syncRoles(['reader']);

        // Categories
        $design = Category::firstOrCreate(['name' => 'Design']);
        $ux = Category::firstOrCreate(['name' => 'UX', 'parent_id' => $design->id]);
        $dev = Category::firstOrCreate(['name' => 'Development']);

        // Posts (published)
        foreach ([
            ['title' => 'Welcome to the Blog', 'category_id' => $design->id, 'status' => 'published'],
            ['title' => 'Design Systems 101', 'category_id' => $ux->id, 'status' => 'published'],
        ] as $data) {
            Post::firstOrCreate(
                ['title' => $data['title']],
                [
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus.',
                    'user_id' => $writer->id,
                    'category_id' => $data['category_id'],
                    'status' => $data['status'],
                    'published_at' => now(),
                    'tags' => 'design,ui,ux',
                ]
            );
        }
    }
}
