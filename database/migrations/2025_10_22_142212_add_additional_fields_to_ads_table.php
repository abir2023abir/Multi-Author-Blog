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
        Schema::table('ads', function (Blueprint $table) {
            $table->integer('width')->nullable()->after('position');
            $table->integer('height')->nullable()->after('width');
            $table->text('description')->nullable()->after('height');
            $table->boolean('is_responsive')->default(true)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['width', 'height', 'description', 'is_responsive']);
        });
    }
};
