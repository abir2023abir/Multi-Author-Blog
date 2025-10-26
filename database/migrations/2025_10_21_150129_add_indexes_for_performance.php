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
            $table->index('status');
            $table->index('user_id');
            $table->index('category_id');
            $table->index('published_at');
            $table->index(['status', 'published_at']);
            $table->index(['status', 'created_at']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->index('post_id');
            $table->index('user_id');
            $table->index('created_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
            $table->index('created_at');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('parent_id');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['published_at']);
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['status', 'created_at']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['post_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['parent_id']);
            $table->dropIndex(['name']);
        });
    }
};
