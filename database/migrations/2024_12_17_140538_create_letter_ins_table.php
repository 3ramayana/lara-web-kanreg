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
        Schema::create('letter_ins', function (Blueprint $table) {
            $table->id();
						$table->string('name');
						$table->foreignId('category_letter_id')->references('id')->on('category_letters')->onDelete('cascade');
						$table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
						$table->foreignId('departement_id')->constrained()->onDelete('cascade');
						$table->string('reference_number');
						$table->date('date_letter');
						$table->date('date_in');
						$table->string('origin_letter');
						$table->string('properties_letter');
						$table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_ins');
    }
};
