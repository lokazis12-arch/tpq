<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = ['santri_id', 'guru_id', 'tanggal', 'status', 'catatan'];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
