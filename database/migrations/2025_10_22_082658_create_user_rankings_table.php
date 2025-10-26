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
        Schema::create('user_rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');
            $table->integer('total_points')->default(0);
            $table->integer('post_points')->default(0);
            $table->integer('comment_points')->default(0);
            $table->integer('view_points')->default(0);
            $table->integer('reaction_points')->default(0);
            $table->integer('rank_position')->nullable(); // Global rank position
            $table->integer('posts_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('total_views')->default(0);
            $table->integer('total_reactions')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->json('achievements')->nullable(); // Store achievement history
            $table->timestamp('last_updated')->useCurrent();
            $table->timestamps();
            
            $table->unique('user_id');
            $table->index(['total_points', 'rank_position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rankings');
    }
};