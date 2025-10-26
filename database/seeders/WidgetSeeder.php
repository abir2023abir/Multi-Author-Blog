<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Widget;

class WidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing widgets
        Widget::truncate();

        // Create widgets matching the image
        Widget::create([
            'name' => 'follow_us',
            'title' => 'Follow Us',
            'language' => 'en',
            'type' => 'Default',
            'where_to_display' => 'Travel (Category)',
            'order' => 2,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subDays(5),
        ]);

        Widget::create([
            'name' => 'popular_tags',
            'title' => 'Popular Tags',
            'language' => 'en',
            'type' => 'Default',
            'where_to_display' => 'Latest Posts',
            'order' => 3,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subDays(4),
        ]);

        Widget::create([
            'name' => 'voting_poll_en',
            'title' => 'Voting Poll',
            'language' => 'en',
            'type' => 'Default',
            'where_to_display' => 'Latest Posts',
            'order' => 5,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subDays(3),
        ]);

        Widget::create([
            'name' => 'voting_poll_ar',
            'title' => 'تصویت تصویت',
            'language' => 'ar',
            'type' => 'Default',
            'where_to_display' => 'أحدث المنشورات',
            'order' => 5,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subDays(2),
        ]);

        Widget::create([
            'name' => 'fashion_category',
            'title' => 'Fashion Widget',
            'language' => 'en',
            'type' => 'Default',
            'where_to_display' => 'Fashion (Category)',
            'order' => 1,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subDays(1),
        ]);

        Widget::create([
            'name' => 'latest_posts',
            'title' => 'Latest Posts',
            'language' => 'en',
            'type' => 'Default',
            'where_to_display' => 'Sidebar',
            'order' => 1,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subHours(12),
        ]);

        Widget::create([
            'name' => 'newsletter_signup',
            'title' => 'Newsletter Signup',
            'language' => 'en',
            'type' => 'Default',
            'where_to_display' => 'Footer',
            'order' => 1,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subHours(8),
        ]);

        Widget::create([
            'name' => 'social_media',
            'title' => 'Social Media',
            'language' => 'en',
            'type' => 'Default',
            'where_to_display' => 'Header',
            'order' => 1,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subHours(6),
        ]);

        Widget::create([
            'name' => 'search_widget',
            'title' => 'Search Widget',
            'language' => 'en',
            'type' => 'Default',
            'where_to_display' => 'Sidebar',
            'order' => 2,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subHours(4),
        ]);

        Widget::create([
            'name' => 'related_posts',
            'title' => 'Related Posts',
            'language' => 'en',
            'type' => 'Default',
            'where_to_display' => 'Post Bottom',
            'order' => 1,
            'is_active' => true,
            'visibility' => true,
            'date_added' => now()->subHours(2),
        ]);
    }
}
