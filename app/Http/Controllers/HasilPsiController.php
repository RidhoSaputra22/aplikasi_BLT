<?php

namespace App\Http\Controllers;

use App\Models\HasilPsi;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilPsiController extends Controller
{
    public function generatePdf($dusun)
    {
        if (empty($dusun)) {
            abort(404, 'Dusun tidak boleh kosong.');
        }

        $hasilPsiData = $dusun === 'Semua'
            ? HasilPsi::with('calon_penerima')->get()
            : HasilPsi::with('calon_penerima')
                ->whereHas('calon_penerima', fn ($q) => $q->where('desa', $dusun))
                ->get();

        $hasilPsi = $hasilPsiData->groupBy('calon_penerima.desa');

        $pdf = Pdf::loadView('pdf.laporan-psi', compact('hasilPsi'))
            ->setPaper('A4', 'portrait');

        $filename = 'Laporan_PSI_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
