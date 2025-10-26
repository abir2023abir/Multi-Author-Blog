<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class SamplePostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        
        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->info('No users or categories found. Please run other seeders first.');
            return;
        }

        $posts = [
            [
                'title' => 'Where the Internet Lives: From Trauma to Triumph Oval',
                'content' => 'The internet has become an integral part of our daily lives, but have you ever wondered where it actually lives? This comprehensive guide explores the physical infrastructure that powers our digital world, from massive data centers to undersea cables connecting continents. We\'ll dive deep into the technology that makes global connectivity possible and the challenges faced in maintaining this critical infrastructure.',
                'category' => 'Technology',
                'featured_image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'Mastering French Cuisine: A Complete Guide',
                'content' => 'French cuisine is renowned worldwide for its elegance, technique, and rich flavors. This comprehensive guide takes you through the fundamentals of French cooking, from basic techniques to advanced preparations. Learn about classic French dishes, essential ingredients, and the cultural significance of French culinary traditions.',
                'category' => 'Architecture',
                'featured_image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'The 2025 World Cup: A Look at the Teams and Players',
                'content' => 'The 2025 World Cup promises to be one of the most exciting tournaments in recent history. With new teams emerging and established powerhouses looking to maintain their dominance, this comprehensive preview covers all the key teams, star players, and storylines to watch. From tactical analysis to player profiles, get ready for the ultimate football spectacle.',
                'category' => 'Technology',
                'featured_image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'The Impact of COVID-19 on The Airport Business',
                'content' => 'The aviation industry faced unprecedented challenges during the COVID-19 pandemic, with airports being among the hardest hit sectors. This in-depth analysis examines how airports adapted to the crisis, the long-term changes in passenger behavior, and the innovative solutions implemented to ensure safety and efficiency. Discover how the industry is rebuilding and what the future holds for air travel.',
                'category' => 'Technology',
                'featured_image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'Sustainable Living: A Guide to Eco-Friendly Practices',
                'content' => 'As environmental concerns continue to grow, more people are embracing sustainable living practices. This comprehensive guide covers everything from reducing your carbon footprint to implementing renewable energy solutions at home. Learn practical tips for sustainable living that benefit both the planet and your wallet.',
                'category' => 'Health',
                'featured_image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'Digital Photography: Capturing the Perfect Moment',
                'content' => 'Digital photography has revolutionized how we capture and share moments. This guide covers essential techniques for both beginners and advanced photographers, from understanding camera settings to post-processing workflows. Learn how to take stunning photos that tell compelling stories.',
                'category' => 'Travel',
                'featured_image' => 'https://images.unsplash.com/photo-1506905925346-04b1e767967a?w=800&h=600&fit=crop',
            ],
        ];

        foreach ($posts as $postData) {
            $category = $categories->where('name', $postData['category'])->first() ?? $categories->random();
            $author = $users->random();
            
            Post::create([
                'title' => $postData['title'],
                'content' => $postData['content'],
                'slug' => Str::slug($postData['title']),
                'excerpt' => Str::limit(strip_tags($postData['content']), 200),
                'status' => 'published',
                'user_id' => $author->id,
                'category_id' => $category->id,
                'featured_image' => $postData['featured_image'],
                'published_at' => now()->subDays(rand(1, 30)),
                'view_count' => rand(100, 5000),
                'tags' => json_encode(['demo', 'sample', 'article']),
                'post_format' => 'standard',
                'meta_description' => Str::limit(strip_tags($postData['content']), 150),
            ]);
        }
    }
}
