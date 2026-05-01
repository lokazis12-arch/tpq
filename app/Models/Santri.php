<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $table = 'santri';
    protected $fillable = ['wali_santri_id', 'nis', 'nama_lengkap', 'alamat', 'pengajian', 'nama_wali', 'status_aktif'];

    public function waliSantri()
    {
        return $this->belongsTo(User::class, 'wali_santri_id');
    }
}
