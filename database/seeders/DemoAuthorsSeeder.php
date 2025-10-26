<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\Badge;
use App\Services\BadgeCalculationService;
use Illuminate\Support\Facades\Hash;

class DemoAuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badgeService = new BadgeCalculationService();

        // Create demo authors with different badge levels
        $authors = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Tech enthusiast and lifestyle blogger with 5+ years of experience.',
                'website' => 'https://sarahjohnson.com',
                'social_links' => [
                    'twitter' => '@sarahjohnson',
                    'instagram' => '@sarahj_blog'
                ],
                'is_verified' => true,
                'posts_count' => 45,
                'views_per_post' => 1200,
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Fitness expert and nutrition coach helping people transform their lives.',
                'website' => 'https://michaelchenfitness.com',
                'social_links' => [
                    'twitter' => '@michaelchenfit',
                    'youtube' => 'Michael Chen Fitness'
                ],
                'is_verified' => true,
                'posts_count' => 38,
                'views_per_post' => 950,
            ],
            [
                'name' => 'Emma Rodriguez',
                'email' => 'emma.rodriguez@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Travel blogger exploring the world one destination at a time.',
                'website' => 'https://emmarodriguez.com',
                'social_links' => [
                    'instagram' => '@emma_travels',
                    'pinterest' => 'Emma Rodriguez Travel'
                ],
                'is_verified' => true,
                'posts_count' => 52,
                'views_per_post' => 1800,
            ],
            [
                'name' => 'David Kim',
                'email' => 'david.kim@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Photography enthusiast capturing life\'s beautiful moments.',
                'website' => 'https://davidkimphotos.com',
                'social_links' => [
                    'instagram' => '@davidkimphotos',
                    'flickr' => 'David Kim Photography'
                ],
                'is_verified' => true,
                'posts_count' => 28,
                'views_per_post' => 750,
            ],
            [
                'name' => 'Lisa Thompson',
                'email' => 'lisa.thompson@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Food blogger and recipe developer sharing delicious creations.',
                'website' => 'https://lisathompsonfood.com',
                'social_links' => [
                    'instagram' => '@lisa_foodie',
                    'youtube' => 'Lisa Thompson Food'
                ],
                'is_verified' => true,
                'posts_count' => 67,
                'views_per_post' => 2200,
            ],
            [
                'name' => 'James Wilson',
                'email' => 'james.wilson@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Business coach helping entrepreneurs build successful companies.',
                'website' => 'https://jameswilsoncoach.com',
                'social_links' => [
                    'linkedin' => 'James Wilson',
                    'twitter' => '@jameswilsoncoach'
                ],
                'is_verified' => true,
                'posts_count' => 31,
                'views_per_post' => 1100,
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Fashion blogger and style influencer with a passion for sustainable fashion.',
                'website' => 'https://mariagarciafashion.com',
                'social_links' => [
                    'instagram' => '@maria_fashion',
                    'pinterest' => 'Maria Garcia Fashion'
                ],
                'is_verified' => true,
                'posts_count' => 41,
                'views_per_post' => 1600,
            ],
            [
                'name' => 'Alex Turner',
                'email' => 'alex.turner@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Gaming content creator and tech reviewer.',
                'website' => 'https://alexturnergaming.com',
                'social_links' => [
                    'youtube' => 'Alex Turner Gaming',
                    'twitch' => 'alexturnergaming'
                ],
                'is_verified' => true,
                'posts_count' => 23,
                'views_per_post' => 850,
            ],
            [
                'name' => 'Sophie Brown',
                'email' => 'sophie.brown@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Wellness coach promoting mental health and mindfulness.',
                'website' => 'https://sophiebrownwellness.com',
                'social_links' => [
                    'instagram' => '@sophie_wellness',
                    'tiktok' => '@sophiebrownwellness'
                ],
                'is_verified' => true,
                'posts_count' => 35,
                'views_per_post' => 1300,
            ],
            [
                'name' => 'Ryan Davis',
                'email' => 'ryan.davis@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Finance expert helping people build wealth and financial freedom.',
                'website' => 'https://ryandavisfinance.com',
                'social_links' => [
                    'twitter' => '@ryandavisfinance',
                    'linkedin' => 'Ryan Davis Finance'
                ],
                'is_verified' => true,
                'posts_count' => 29,
                'views_per_post' => 1400,
            ],
        ];

        foreach ($authors as $authorData) {
            $user = User::firstOrCreate(
                ['email' => $authorData['email']],
                [
                    'name' => $authorData['name'],
                    'email' => $authorData['email'],
                    'password' => $authorData['password'],
                    'bio' => $authorData['bio'],
                    'website' => $authorData['website'],
                    'social_links' => $authorData['social_links'],
                    'is_verified' => $authorData['is_verified'],
                    'last_activity' => now()->subDays(rand(0, 30)),
                ]
            );

            // Create posts for this author
            for ($i = 1; $i <= $authorData['posts_count']; $i++) {
                $post = Post::create([
                    'title' => "Amazing Post {$i} by {$authorData['name']}",
                    'content' => "This is the content of post {$i} by {$authorData['name']}. " . str_repeat("Lorem ipsum dolor sit amet, consectetur adipiscing elit. ", 20),
                    'status' => 'published',
                    'user_id' => $user->id,
                    'category_id' => rand(1, 10), // Assuming categories 1-10 exist
                    'view_count' => rand($authorData['views_per_post'] - 200, $authorData['views_per_post'] + 200),
                    'published_at' => now()->subDays(rand(0, 90)),
                    'tags' => ['demo', 'sample', 'test'],
                ]);

                // Create some comments for this post
                $commentCount = rand(2, 8);
                for ($j = 1; $j <= $commentCount; $j++) {
                    Comment::create([
                        'post_id' => $post->id,
                        'user_id' => User::inRandomOrder()->first()->id,
                        'content' => "Great post! This is comment {$j} on post {$i}.",
                        'author_name' => "Commenter {$j}",
                        'author_email' => "commenter{$j}@example.com",
                    ]);
                }

                // Create some reactions for this post
                $reactionCount = rand(5, 15);
                $usedUsers = [];
                for ($k = 1; $k <= $reactionCount; $k++) {
                    $reactionTypes = ['like', 'love', 'laugh', 'wow'];
                    $randomUser = User::inRandomOrder()->first();

                    // Avoid duplicate reactions from same user on same post
                    if (!in_array($randomUser->id, $usedUsers)) {
                        Reaction::create([
                            'post_id' => $post->id,
                            'user_id' => $randomUser->id,
                            'type' => $reactionTypes[array_rand($reactionTypes)],
                        ]);
                        $usedUsers[] = $randomUser->id;
                    }
                }
            }

            // Update user's badge based on their activities
            $badgeService->updateUserBadge($user);
        }

        // Update all rankings
        $badgeService->updateRankings();
    }
}
