<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Shankar Mahadevan x Music AI | Google Lab Sessions',
                'description' => 'Experience the fusion of traditional Indian music with cutting-edge AI technology in this exclusive Google Lab Session featuring Shankar Mahadevan.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400&h=225&fit=crop',
                'duration' => '4:32',
                'category' => 'Music',
                'author_name' => 'Google Lab Sessions',
                'author_channel' => 'https://youtube.com/@GoogleLabSessions',
                'views_count' => 1250000,
                'likes_count' => 45000,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Kingfisher Bird - Nature Documentary',
                'description' => 'A stunning close-up look at the vibrant kingfisher bird in its natural habitat, showcasing its incredible hunting techniques.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1506905925346-04b1e767967a?w=400&h=225&fit=crop',
                'duration' => '3:15',
                'category' => 'Nature',
                'author_name' => 'Wildlife Channel',
                'author_channel' => 'https://youtube.com/@WildlifeChannel',
                'views_count' => 890000,
                'likes_count' => 32000,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Sea Turtle Migration - Ocean Wonders',
                'description' => 'Follow the incredible journey of sea turtles as they navigate thousands of miles across the ocean.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=225&fit=crop',
                'duration' => '6:45',
                'category' => 'Nature',
                'author_name' => 'Ocean Explorer',
                'author_channel' => 'https://youtube.com/@OceanExplorer',
                'views_count' => 2100000,
                'likes_count' => 78000,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Lizard Camouflage Techniques',
                'description' => 'Discover how lizards use advanced camouflage techniques to survive in their natural environment.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1506905925346-04b1e767967a?w=400&h=225&fit=crop',
                'duration' => '2:30',
                'category' => 'Nature',
                'author_name' => 'Reptile World',
                'author_channel' => 'https://youtube.com/@ReptileWorld',
                'views_count' => 450000,
                'likes_count' => 18000,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Wind Turbines in Snowy Landscape',
                'description' => 'Aerial view of wind turbines generating clean energy in a beautiful snowy mountain landscape.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=225&fit=crop',
                'duration' => '5:20',
                'category' => 'Technology',
                'author_name' => 'Green Energy Today',
                'author_channel' => 'https://youtube.com/@GreenEnergyToday',
                'views_count' => 670000,
                'likes_count' => 25000,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Cooking Masterclass: Italian Pasta',
                'description' => 'Learn to make authentic Italian pasta from scratch with this step-by-step cooking tutorial.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=225&fit=crop',
                'duration' => '12:15',
                'category' => 'Education',
                'author_name' => 'Chef Marco',
                'author_channel' => 'https://youtube.com/@ChefMarco',
                'views_count' => 340000,
                'likes_count' => 15000,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
                'published_at' => now()->subDays(4),
            ],
        ];

        foreach ($videos as $video) {
            Video::create($video);
        }
    }
}
