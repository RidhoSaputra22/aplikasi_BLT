<?php

namespace App\Http\Controllers;

use App\Models\HasilPsi;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Requests\StoreHasilPsiRequest;
use App\Http\Requests\UpdateHasilPsiRequest;

class HasilPsiController extends Controller
{
    public function generatePdf()
    {
        // Logic to generate PDF report
        $hasilPsi = HasilPsi::all();
        return Pdf::view('pdf.laporan-psi', compact('hasilPsi'))
            ->format('A4') // Or your desired paper size
            ->margins(4, 4, 3, 3) // Top, Right, Bottom, Left (in cm) - This likely won't directly correspond to margins
            ->name('laporan-psi.pdf')
            ->inline();
    }
}
