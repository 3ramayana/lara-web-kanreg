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
        Schema::create('asn_statistics', function (Blueprint $table) {
            $table->id();
            
            // Primary Identifiers
            $table->year('year');
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->enum('employee_type', ['PNS', 'PPPK']);

            // Unique constraint to prevent duplicate reports
            $table->unique(['year', 'city_id', 'employee_type']);

            // Gender
            $table->integer('gender_male')->default(0);
            $table->integer('gender_female')->default(0);

            // Education
            $table->integer('edu_sd')->default(0);
            $table->integer('edu_smp')->default(0);
            $table->integer('edu_sma')->default(0);
            $table->integer('edu_d1')->default(0);
            $table->integer('edu_d2')->default(0);
            $table->integer('edu_d3')->default(0);
            $table->integer('edu_d4')->default(0);
            $table->integer('edu_s1')->default(0);
            $table->integer('edu_s2')->default(0);
            $table->integer('edu_s3')->default(0);
            $table->integer('edu_profesi')->default(0);

            // Position (Jabatan)
            $table->integer('pos_jpt_madya')->default(0);
            $table->integer('pos_jpt_pratama')->default(0);
            $table->integer('pos_administrator')->default(0);
            $table->integer('pos_pengawas')->default(0);
            $table->integer('pos_fungsional')->default(0);
            $table->integer('pos_pelaksana')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asn_statistics');
    }
};
