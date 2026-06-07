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
            $table->index('category_id');
            $table->index('is_headline');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['is_headline']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });
    }
};
