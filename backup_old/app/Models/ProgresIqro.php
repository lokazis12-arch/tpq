<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresIqro extends Model
{
    protected $table = 'progres_iqro';
    protected $fillable = [
        'santri_id', 'guru_id', 'tanggal', 'kategori', 'level', 'halaman', 'status_lulus', 'catatan_guru',
        'iqro_1_pages', 'iqro_2_pages', 'iqro_3_pages', 'iqro_4_pages', 'iqro_5_pages', 'iqro_6_pages',
        'juz_30_surahs',
        'tajwid_nun_mati', 'tajwid_mim_mati', 'tajwid_mad', 'tajwid_berhenti'
    ];

    protected $casts = [
        'iqro_1_pages' => 'array',
        'iqro_2_pages' => 'array',
        'iqro_3_pages' => 'array',
        'iqro_4_pages' => 'array',
        'iqro_5_pages' => 'array',
        'iqro_6_pages' => 'array',
        'juz_30_surahs' => 'array',
        'tajwid_nun_mati' => 'array',
        'tajwid_mim_mati' => 'array',
        'tajwid_mad' => 'array',
        'tajwid_berhenti' => 'array',
        'status_lulus' => 'boolean',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
