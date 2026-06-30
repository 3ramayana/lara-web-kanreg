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
        Schema::table('asn_statistics', function (Blueprint $table) {
            $table->integer('month')->after('year')->default(1); // Default to January for existing records
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asn_statistics', function (Blueprint $table) {
            $table->dropColumn('month');
        });
    }
};
