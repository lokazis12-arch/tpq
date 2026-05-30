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
        Schema::table('progres_iqro', function (Blueprint $table) {
            // Iqro pages - JSON to store page completion status
            $table->json('iqro_1_pages')->nullable();
            $table->json('iqro_2_pages')->nullable();
            $table->json('iqro_3_pages')->nullable();
            $table->json('iqro_4_pages')->nullable();
            $table->json('iqro_5_pages')->nullable();
            $table->json('iqro_6_pages')->nullable();
            
            // Juz 30 surahs - JSON to store surah completion status
            $table->json('juz_30_surahs')->nullable();
            
            // Tajwid rules - JSON to store rule completion status
            $table->json('tajwid_nun_mati')->nullable();
            $table->json('tajwid_mim_mati')->nullable();
            $table->json('tajwid_mad')->nullable();
            $table->json('tajwid_berhenti')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progres_iqro', function (Blueprint $table) {
            $table->dropColumn([
                'iqro_1_pages', 'iqro_2_pages', 'iqro_3_pages', 'iqro_4_pages', 'iqro_5_pages', 'iqro_6_pages',
                'juz_30_surahs',
                'tajwid_nun_mati', 'tajwid_mim_mati', 'tajwid_mad', 'tajwid_berhenti'
            ]);
        });
    }
};
