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
    Schema::create('questions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('city_id')->constrained()->onDelete('cascade');
      $table->foreignId('ministry_id')->constrained()->onDelete('cascade');
      $table->foreignId('question_category_id')->constrained()->onDelete('cascade');
      $table->string('nip')->default('000000');
      $table->string('name');
      $table->string('wa');
      $table->text('pesan');
      // $table->string('instansi');
      // $table->boolean('status')->default(false)->nullable();
      $table->enum('status', ['Belum Dijawab', 'Sudah Dijawab'])->default('Belum Dijawab');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('questions');
  }
};
