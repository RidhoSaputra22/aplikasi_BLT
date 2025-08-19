<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    /** @use HasFactory<\Database\Factories\KriteriaFactory> */
    use HasFactory;
    protected $fillable = [
        'nama_kriteria',
        'tipe',
        'kode',
    ];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class);
    }
}
