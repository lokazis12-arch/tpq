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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('jumlah_bayar', 10, 2)->default(0);
            $table->enum('status', ['lunas', 'belum_bayar'])->default('belum_bayar');
            $table->date('tanggal_bayar')->nullable();
            $table->foreignId('penerima_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
