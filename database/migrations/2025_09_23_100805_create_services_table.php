<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('link')->nullable();
            $table->string('document')->nullable();
            $table->enum('category', ['cat', 'cltn', 'kp', 'mt', 'mutasi', 'nip', 'pensiun', 'pengangkatan', 'pg', 'peremajaan', 'pmk', 'statistik', 'janda_duda', 'pembinaan', 'pengaktifan']);
            $table->string('periode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
