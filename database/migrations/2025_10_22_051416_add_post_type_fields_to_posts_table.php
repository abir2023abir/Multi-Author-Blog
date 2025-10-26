<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_slider')->default(false)->after('featured_image');
            $table->boolean('is_featured')->default(false)->after('is_slider');
            $table->boolean('is_breaking')->default(false)->after('is_featured');
            $table->boolean('is_recommended')->default(false)->after('is_breaking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['is_slider', 'is_featured', 'is_breaking', 'is_recommended']);
        });
    }
};