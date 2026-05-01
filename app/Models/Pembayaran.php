<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = ['santri_id', 'bulan', 'tahun', 'jumlah_bayar', 'status', 'tanggal_bayar', 'penerima_id'];

    public function santri()
    {
        return $this->belongsTo(\App\Models\Santri::class);
    }
}
