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

    static function calculate()
    {
        $periode = now()->format('Y-m');

        // Hapus hasil sebelumnya dan hitung ulang
        HasilPsi::where('periode', $periode)->delete();

        $kriterias = Kriteria::all();
        $calons = CalonPenerima::with('penilaian')->get();

        $nilaiKriteria = [];
        foreach ($kriterias as $kriteria) {
            $nilaiKriteria[$kriteria->id] = Penilaian::where('kriteria_id', $kriteria->id)->pluck('nilai');
        }

        $hasil = [];
        foreach ($calons as $calon) {
            $totalPreferensi = 0;
            foreach ($kriterias as $kriteria) {
                $nilai = Penilaian::where('calon_penerima_id', $calon->id)
                    ->where('kriteria_id', $kriteria->id)
                    ->value('nilai');

                $allNilai = $nilaiKriteria[$kriteria->id];
                $max = $allNilai->max();
                $min = $allNilai->min();

                if ($kriteria->tipe === 'Benefit') {
                    $normal = $nilai / ($max ?: 1);
                } else {
                    $normal = ($min ?: 1) / ($nilai ?: 1);
                }

                $preferensi = $normal * $kriteria->bobot;
                $totalPreferensi += $preferensi;
            }

            $hasil[] = [
                'calon_penerima_id' => $calon->id,
                'nilai_preferensi' => round($totalPreferensi, 4),
                'periode' => $periode,
                'status' => $totalPreferensi >= 0.75 ? 'Layak' : 'Tidak Layak',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Simpan hasil
        HasilPsi::insert($hasil);
    }
}
