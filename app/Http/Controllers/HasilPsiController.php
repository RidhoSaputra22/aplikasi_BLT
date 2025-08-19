<?php

namespace App\Http\Controllers;

use App\Models\HasilPsi;
use App\Http\Requests\StoreHasilPsiRequest;
use App\Http\Requests\UpdateHasilPsiRequest;

class HasilPsiController extends Controller
{
    public function generatePdf()
    {
        // Logic to generate PDF report
        $hasilPsi = HasilPsi::all();
        $pdf = PDF::loadView('laporan.psi', compact('hasilPsi'));
        return $pdf->download('laporan-psi.pdf');
    }
}
