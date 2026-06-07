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
            // Golongan PNS
            $table->integer('gol_pns_1')->default(0);
            $table->integer('gol_pns_2')->default(0);
            $table->integer('gol_pns_3')->default(0);
            $table->integer('gol_pns_4')->default(0);

            // Golongan PPPK
            $table->integer('gol_pppk_1')->default(0);
            $table->integer('gol_pppk_2')->default(0);
            $table->integer('gol_pppk_3')->default(0);
            $table->integer('gol_pppk_4')->default(0);
            $table->integer('gol_pppk_5')->default(0);
            $table->integer('gol_pppk_6')->default(0);
            $table->integer('gol_pppk_7')->default(0);
            $table->integer('gol_pppk_8')->default(0);
            $table->integer('gol_pppk_9')->default(0);
            $table->integer('gol_pppk_10')->default(0);
            $table->integer('gol_pppk_11')->default(0);

            // Masa Kerja
            $table->integer('mk_0_5')->default(0);
            $table->integer('mk_6_10')->default(0);
            $table->integer('mk_11_15')->default(0);
            $table->integer('mk_16_20')->default(0);
            $table->integer('mk_21_25')->default(0);
            $table->integer('mk_26_30')->default(0);
            $table->integer('mk_30_plus')->default(0);

            // Usia
            $table->integer('age_17_20')->default(0);
            $table->integer('age_21_30')->default(0);
            $table->integer('age_31_40')->default(0);
            $table->integer('age_41_50')->default(0);
            $table->integer('age_51_58')->default(0);
            $table->integer('age_58_plus')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asn_statistics', function (Blueprint $table) {
            $table->dropColumn([
                'gol_pns_1', 'gol_pns_2', 'gol_pns_3', 'gol_pns_4',
                'gol_pppk_1', 'gol_pppk_2', 'gol_pppk_3', 'gol_pppk_4', 'gol_pppk_5', 'gol_pppk_6', 'gol_pppk_7', 'gol_pppk_8', 'gol_pppk_9', 'gol_pppk_10', 'gol_pppk_11',
                'mk_0_5', 'mk_6_10', 'mk_11_15', 'mk_16_20', 'mk_21_25', 'mk_26_30', 'mk_30_plus',
                'age_17_20', 'age_21_30', 'age_31_40', 'age_41_50', 'age_51_58', 'age_58_plus'
            ]);
        });
    }
};
