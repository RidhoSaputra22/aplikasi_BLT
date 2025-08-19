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
        'sub_kriteria_id',
    ];

    public function calonPenerima()
    {
        return $this->belongsTo(CalonPenerima::class, 'calon_penerima_id', 'id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'sub_kriteria_id', 'id');
    }
}
