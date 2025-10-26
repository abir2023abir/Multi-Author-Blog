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
        Schema::table('users', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('users', 'badge_id')) {
                $table->foreignId('badge_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'total_points')) {
                $table->integer('total_points')->default(0);
            }
            if (!Schema::hasColumn('users', 'rank_position')) {
                $table->integer('rank_position')->nullable();
            }
            if (!Schema::hasColumn('users', 'achievements')) {
                $table->json('achievements')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->boolean('is_verified')->default(false);
            }
            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable();
            }
            if (!Schema::hasColumn('users', 'social_links')) {
                $table->json('social_links')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'badge_id')) {
                $table->dropForeign(['badge_id']);
                $table->dropColumn('badge_id');
            }
            if (Schema::hasColumn('users', 'total_points')) {
                $table->dropColumn('total_points');
            }
            if (Schema::hasColumn('users', 'rank_position')) {
                $table->dropColumn('rank_position');
            }
            if (Schema::hasColumn('users', 'achievements')) {
                $table->dropColumn('achievements');
            }
            if (Schema::hasColumn('users', 'is_verified')) {
                $table->dropColumn('is_verified');
            }
            if (Schema::hasColumn('users', 'website')) {
                $table->dropColumn('website');
            }
            if (Schema::hasColumn('users', 'social_links')) {
                $table->dropColumn('social_links');
            }
        });
    }
};
