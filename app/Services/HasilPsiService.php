<?php

namespace App\Services;

use App\Models\HasilPsi;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HasilPsiService
{
    /**
     * Hitung PSI (Preference Selection Index) dari tabel penilaian.
     *
     * @return int jumlah row hasil yang diinsert
     */
    public function hitung(?Carbon $periode = null): int
    {
        $periode = $periode ?? now();
        $periodeKey = $periode->format('Y-m');

        // Hapus hasil PSI sebelumnya untuk periode ini
        DB::table('hasil_psis')->where('periode', $periodeKey)->delete();

        // Ambil semua penilaian
        $penilaians = Penilaian::all();

        if ($penilaians->isEmpty()) {
            return 0;
        }

        // Ambil calon penerima dan kriteria unik dari penilaian
        $calonIds = $penilaians->pluck('calon_penerima_id')->unique()->values();
        $kriteriaIds = $penilaians->pluck('kriteria_id')->unique()->values();

        // Matriks penilaian: [calon][kriteria] = bobot sub_kriteria
        $matriks = [];
        foreach ($calonIds as $calonId) {
            foreach ($kriteriaIds as $kriteriaId) {
                $penilaian = $penilaians->firstWhere(function ($p) use ($calonId, $kriteriaId) {
                    return (int) $p->calon_penerima_id === (int) $calonId
                        && (int) $p->kriteria_id === (int) $kriteriaId;
                });

                $bobot = 0;
                if ($penilaian && $penilaian->sub_kriteria_id) {
                    $subKriteria = SubKriteria::find($penilaian->sub_kriteria_id);
                    $bobot = $subKriteria ? (float) $subKriteria->bobot : 0;
                }

                $matriks[$calonId][$kriteriaId] = $bobot;
            }
        }

        // Normalisasi matriks (asumsi semua benefit)
        $normalisasi = [];
        foreach ($kriteriaIds as $kriteriaId) {
            $nilaiKriteria = [];
            foreach ($calonIds as $calonId) {
                $nilaiKriteria[] = $matriks[$calonId][$kriteriaId] ?? 0;
            }

            $max = ! empty($nilaiKriteria) ? max($nilaiKriteria) : 0;

            foreach ($calonIds as $calonId) {
                $xij = $matriks[$calonId][$kriteriaId] ?? 0;
                $rij = $max ? ($xij / $max) : 0;
                $normalisasi[$calonId][$kriteriaId] = $rij;
            }
        }

        // Hitung nilai mean tiap calon
        $mean = [];
        $kCount = max(count($kriteriaIds), 1);
        foreach ($calonIds as $calonId) {
            $mean[$calonId] = array_sum($normalisasi[$calonId]) / $kCount;
        }

        // Hitung nilai preferensi tiap calon (tetap dipertahankan seperti kode awal, walau tidak dipakai di indeks akhir)
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
                $penilaian = $penilaians->firstWhere(function ($p) use ($calonId, $kriteriaId) {
                    return (int) $p->calon_penerima_id === (int) $calonId
                        && (int) $p->kriteria_id === (int) $kriteriaId;
                });

                if ($penilaian && $penilaian->sub_kriteria_id) {
                    $subKriteria = SubKriteria::find($penilaian->sub_kriteria_id);
                    if ($subKriteria) {
                        $bobotArr[] = (float) $subKriteria->bobot;
                    }
                }
            }
            $aj[$kriteriaId] = count($bobotArr) ? array_sum($bobotArr) / count($bobotArr) : 0;
        }

        $sumAj = array_sum($aj);
        $wj = [];
        foreach ($kriteriaIds as $kriteriaId) {
            $wj[$kriteriaId] = $sumAj ? ($aj[$kriteriaId] / $sumAj) : 0;
        }

        // Hitung indeks pemilihan preferensi dan simpan hasil
        $now = now();
        $hasil = [];
        foreach ($calonIds as $calonId) {
            $indeks = 0;
            foreach ($kriteriaIds as $kriteriaId) {
                $rij = $normalisasi[$calonId][$kriteriaId];
                $indeks += $rij * ($wj[$kriteriaId] ?? 0);
            }

            $hasil[] = [
                'calon_penerima_id' => $calonId,
                'nilai_preferensi' => round($indeks, 4),
                'periode' => $periodeKey,
                'status' => $indeks >= 0.75 ? 'Layak' : 'Tidak Layak',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($hasil)) {
            HasilPsi::insert($hasil);
        }

        return count($hasil);
    }
}
