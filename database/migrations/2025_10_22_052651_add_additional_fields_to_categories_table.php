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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('language')->default('en')->after('name');
            $table->integer('order')->default(0)->after('parent_id');
            $table->string('color')->default('#3B82F6')->after('order');
            $table->boolean('status')->default(true)->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['language', 'order', 'color', 'status']);
        });
    }
};