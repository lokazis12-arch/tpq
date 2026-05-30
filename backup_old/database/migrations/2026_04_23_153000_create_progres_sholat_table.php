<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration { public function up(): void { Schema::create('progres_sholat', function (Blueprint $table) { $table->id(); $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade'); $table->foreignId('guru_id')->constrained('users')->onDelete('cascade'); $table->date('tanggal'); $table->boolean('niat')->default(false); $table->boolean('takbiratul_ihram')->default(false); $table->boolean('doa_iftitah')->default(false); $table->boolean('al_fatihah')->default(false); $table->boolean('surat_ayat')->default(false); $table->boolean('bacaan_ruku')->default(false); $table->boolean('bacaan_itidal')->default(false); $table->boolean('bacaan_sujud')->default(false); $table->boolean('duduk_antara_sujud')->default(false); $table->boolean('tasyahud_awal')->default(false); $table->boolean('tasyahud_akhir')->default(false); $table->boolean('sholawat_nabi')->default(false); $table->boolean('doa_sebelum_salam')->default(false); $table->boolean('salam')->default(false); $table->boolean('status_lulus')->default(false); $table->text('catatan_guru')->nullable(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('progres_sholat'); } };
