<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonPenerima extends Model
{
    /** @use HasFactory<\Database\Factories\CalonPenerimaFactory> */
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'no_kk',
        'desa',
        'kecamatan',
        'kabupaten',
        'tanggal_input',
    ];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
