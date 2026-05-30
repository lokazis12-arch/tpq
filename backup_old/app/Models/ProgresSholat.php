<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresSholat extends Model
{
    protected $table = 'progres_sholat';
    protected $fillable = ['santri_id', 'guru_id', 'tanggal', 'niat', 'takbiratul_ihram', 'doa_iftitah', 'al_fatihah', 'surat_ayat', 'bacaan_ruku', 'bacaan_itidal', 'bacaan_sujud', 'duduk_antara_sujud', 'tasyahud_awal', 'tasyahud_akhir', 'sholawat_nabi', 'doa_sebelum_salam', 'salam', 'status_lulus', 'catatan_guru'];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function getCompletedCountAttribute()
    {
        $fields = ['niat', 'takbiratul_ihram', 'doa_iftitah', 'al_fatihah', 'surat_ayat', 'bacaan_ruku', 'bacaan_itidal', 'bacaan_sujud', 'duduk_antara_sujud', 'tasyahud_awal', 'tasyahud_akhir', 'sholawat_nabi', 'doa_sebelum_salam', 'salam'];
        return collect($fields)->filter(fn($field) => $this->$field)->count();
    }

    public function getProgressPercentageAttribute()
    {
        return ($this->completed_count / 14) * 100;
    }
}
