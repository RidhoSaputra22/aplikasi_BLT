<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPsi extends Model
{
    /** @use HasFactory<\Database\Factories\HasilPsiFactory> */
    use HasFactory;

    protected $fillable = [
        'calon_penerima_id',
        'nilai_preferensi',
        'periode',
        'status',
    ];

    public function calon_penerima()
    {
        return $this->belongsTo(CalonPenerima::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function kriteria()
    {
        return $this->hasMany(Kriteria::class);
    }
}
