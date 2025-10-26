<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing categories
        Category::truncate();

        // Create parent categories
        $rssNews = Category::create(['name' => 'RSS News', 'language' => 'en', 'order' => 6, 'color' => '#374151', 'status' => true]);
        $fashion = Category::create(['name' => 'Fashion', 'language' => 'en', 'order' => 4, 'color' => '#3B82F6', 'status' => true]);
        $travel = Category::create(['name' => 'Travel', 'language' => 'en', 'order' => 3, 'color' => '#14B8A6', 'status' => true]);
        $lifeStyle = Category::create(['name' => 'Life Style', 'language' => 'en', 'order' => 2, 'color' => '#EF4444', 'status' => true]);
        $sport = Category::create(['name' => 'Sport', 'language' => 'en', 'order' => 7, 'color' => '#3B82F6', 'status' => true]);
        $quizzes = Category::create(['name' => 'Quizzes', 'language' => 'en', 'order' => 5, 'color' => '#F97316', 'status' => true]);
        $videos = Category::create(['name' => 'Videos', 'language' => 'en', 'order' => 8, 'color' => '#8B5CF6', 'status' => true]);

        // Create child categories
        Category::create(['name' => 'ABC News', 'language' => 'en', 'parent_id' => $rssNews->id, 'order' => 3, 'color' => '#374151', 'status' => true]);
        Category::create(['name' => 'The New York Times', 'language' => 'en', 'parent_id' => $rssNews->id, 'order' => 2, 'color' => '#374151', 'status' => true]);
        Category::create(['name' => 'CBS News', 'language' => 'en', 'parent_id' => $rssNews->id, 'order' => 1, 'color' => '#374151', 'status' => true]);
        Category::create(['name' => 'Clothes', 'language' => 'en', 'parent_id' => $fashion->id, 'order' => 1, 'color' => '#3B82F6', 'status' => true]);
        Category::create(['name' => 'Places', 'language' => 'en', 'parent_id' => $travel->id, 'order' => 2, 'color' => '#14B8A6', 'status' => true]);
        Category::create(['name' => 'Nature', 'language' => 'en', 'parent_id' => $travel->id, 'order' => 1, 'color' => '#14B8A6', 'status' => true]);
        Category::create(['name' => 'Recipes', 'language' => 'en', 'parent_id' => $lifeStyle->id, 'order' => 3, 'color' => '#EF4444', 'status' => true]);
        Category::create(['name' => 'Design', 'language' => 'en', 'parent_id' => $lifeStyle->id, 'order' => 2, 'color' => '#EF4444', 'status' => true]);
        Category::create(['name' => 'Photography', 'language' => 'en', 'parent_id' => $lifeStyle->id, 'order' => 1, 'color' => '#EF4444', 'status' => true]);
    }
}