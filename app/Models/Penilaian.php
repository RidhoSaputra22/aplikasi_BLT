<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    /** @use HasFactory<\Database\Factories\PenilaianFactory> */
    use HasFactory;
    protected $fillable = [
        'calon_penerima_id',
        'kriteria_id',
        'nilai',
    ];

    public function calon_penerima()
    {
        return $this->belongsTo(CalonPenerima::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
