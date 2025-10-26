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
        Schema::table('widgets', function (Blueprint $table) {
            $table->string('title')->after('name');
            $table->string('language')->default('en')->after('title');
            $table->string('where_to_display')->after('language');
            $table->integer('order')->default(0)->after('where_to_display');
            $table->boolean('visibility')->default(true)->after('is_active');
            $table->timestamp('date_added')->useCurrent()->after('visibility');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('widgets', function (Blueprint $table) {
            $table->dropColumn(['title', 'language', 'where_to_display', 'order', 'visibility', 'date_added']);
        });
    }
};