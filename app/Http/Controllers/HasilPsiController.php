<?php

namespace App\Http\Controllers;

use App\Models\HasilPsi;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Requests\StoreHasilPsiRequest;
use App\Http\Requests\UpdateHasilPsiRequest;

class HasilPsiController extends Controller
{
    public function generatePdf($dusun)
    {

        if (empty($dusun)) {
            abort(404, 'Dusun tidak boleh kosong.');
        }

        // Logic to generate PDF report
        // Ambil semua hasil PSI dengan relasi calon_penerima
        if ($dusun == 'Semua') {
            $hasilPsiData = HasilPsi::with('calon_penerima')->get();
        } else {
            $hasilPsiData = HasilPsi::with('calon_penerima')->whereHas('calon_penerima', function ($query) use ($dusun) {
                $query->where('desa', $dusun);
            })->get();
        }
        // Pisahkan data berdasarkan desa
        $hasilPsi = $hasilPsiData->groupBy('calon_penerima.desa');
        return Pdf::view('pdf.laporan-psi', compact('hasilPsi'))
            ->format('A4') // Or your desired paper size
            ->margins(4, 4, 3, 3) // Top, Right, Bottom, Left (in cm) - This likely won't directly correspond to margins
            ->name('Laporan_PSI ' . now()->format('Y-m-d') . '.pdf');
    }
}
