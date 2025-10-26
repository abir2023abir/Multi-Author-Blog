<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_url')->nullable()->after('remember_token');
            $table->text('bio')->nullable()->after('avatar_url');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('view_count')->default(0)->after('status');
            $table->timestamp('published_at')->nullable()->after('view_count');
            $table->string('tags')->nullable()->after('published_at');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['view_count', 'published_at', 'tags']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar_url', 'bio']);
        });
    }
};


