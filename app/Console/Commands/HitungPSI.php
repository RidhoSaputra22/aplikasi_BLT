<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use App\Models\HasilPsi;
use Illuminate\Support\Facades\DB;

class HitungPSI extends Command
{
    protected $signature = 'psi:hitung';
    protected $description = 'Hitung PSI (Preference Selection Index) hanya dari tabel penilaian';

    public function handle()
    {
        // Hapus hasil PSI sebelumnya untuk periode ini
        DB::table('hasil_psis')->where('periode', now()->format('Y-m'))->delete();

        $periode = now()->format('Y-m');
        HasilPsi::where('periode', $periode)->delete();

        // Ambil semua penilaian
        $penilaians = Penilaian::all();

        // Ambil calon penerima dan kriteria unik dari penilaian
        $calonIds = $penilaians->pluck('calon_penerima_id')->unique();
        $kriteriaIds = $penilaians->pluck('kriteria_id')->unique();

        // Matriks penilaian: [calon][kriteria] = bobot sub_kriteria
        $matriks = [];
        foreach ($calonIds as $calonId) {
            foreach ($kriteriaIds as $kriteriaId) {
                $penilaian = $penilaians->where('calon_penerima_id', $calonId)
                    ->where('kriteria_id', $kriteriaId)
                    ->first();

                $bobot = 0;
                if ($penilaian && $penilaian->sub_kriteria_id) {
                    $subKriteria = SubKriteria::find($penilaian->sub_kriteria_id);
                    $bobot = $subKriteria ? $subKriteria->bobot : 0;
                }
                $matriks[$calonId][$kriteriaId] = $bobot;
            }
        }

        // Normalisasi matriks
        $normalisasi = [];
        foreach ($kriteriaIds as $kriteriaId) {
            $nilaiKriteria = array_column($matriks, $kriteriaId);
            $max = max($nilaiKriteria);
            $min = min($nilaiKriteria);

            foreach ($calonIds as $calonId) {
                $xij = $matriks[$calonId][$kriteriaId];
                // Asumsi semua kriteria benefit, jika ada tipe cost silakan modifikasi
                $rij = $max ? $xij / $max : 0;
                $normalisasi[$calonId][$kriteriaId] = $rij;
            }
        }

        // Hitung nilai mean tiap calon
        $mean = [];
        foreach ($calonIds as $calonId) {
            $mean[$calonId] = array_sum($normalisasi[$calonId]) / count($kriteriaIds);
        }

        // Hitung nilai preferensi tiap calon
        $preferensi = [];
        foreach ($calonIds as $calonId) {
            $sum = 0;
            foreach ($kriteriaIds as $kriteriaId) {
                $rij = $normalisasi[$calonId][$kriteriaId];
                $nj = $mean[$calonId];
                $sum += pow($rij - $nj, 2);
            }
            $preferensi[$calonId] = $sum;
        }

        // Hitung bobot kriteria dari rata-rata bobot sub_kriteria pada penilaian
        $aj = [];
        foreach ($kriteriaIds as $kriteriaId) {
            $bobotArr = [];
            foreach ($calonIds as $calonId) {
                $penilaian = $penilaians->where('calon_penerima_id', $calonId)
                    ->where('kriteria_id', $kriteriaId)
                    ->first();
                if ($penilaian && $penilaian->sub_kriteria_id) {
                    $subKriteria = SubKriteria::find($penilaian->sub_kriteria_id);
                    if ($subKriteria) {
                        $bobotArr[] = $subKriteria->bobot;
                    }
                }
            }
            $aj[$kriteriaId] = count($bobotArr) ? array_sum($bobotArr) / count($bobotArr) : 0;
        }
        $sumAj = array_sum($aj);
        $wj = [];
        foreach ($kriteriaIds as $kriteriaId) {
            $wj[$kriteriaId] = $sumAj ? $aj[$kriteriaId] / $sumAj : 0;
        }

        // Hitung indeks pemilihan preferensi
        $hasil = [];
        foreach ($calonIds as $calonId) {
            $indeks = 0;
            foreach ($kriteriaIds as $kriteriaId) {
                $rij = $normalisasi[$calonId][$kriteriaId];
                $indeks += $rij * $wj[$kriteriaId];
            }
            $hasil[] = [
                'calon_penerima_id' => $calonId,
                'nilai_preferensi' => round($indeks, 4),
                'periode' => $periode,
                'status' => $indeks >= 0.75 ? 'Layak' : 'Tidak Layak',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        HasilPsi::insert($hasil);

        $this->info('Perhitungan PSI selesai!');
    }
}
