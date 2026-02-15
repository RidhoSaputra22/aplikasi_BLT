<?php

namespace App\Http\Controllers;

use App\Models\HasilPsi;
use Spatie\LaravelPdf\Facades\Pdf;

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

        return Pdf::view('pdf.laporan-psi', compact('hasilPsi'))
            ->format('A4')
            ->withBrowsershot(function ($browsershot) {

                // === Tambahan: Node & NPM binary (shared hosting) ===
                if ($node = config('browsershot.node_binary')) {
                    $browsershot->setNodeBinary($node);
                }
                if ($npm = config('browsershot.npm_binary')) {
                    $browsershot->setNpmBinary($npm);
                }

                // Chrome path (punya kamu)
                $browsershot->setChromePath(config('browsershot.chrome_path'));

                $isWindows = PHP_OS_FAMILY === 'Windows';

                if ($isWindows) {
                    $browsershot->addChromiumArguments(['--disable-gpu']);
                } else {
                    $browsershot->addChromiumArguments([
                        '--no-sandbox',
                        '--disable-setuid-sandbox',
                        '--disable-dev-shm-usage',
                    ]);
                }

                $browsershot->margins(4, 4, 3, 3);
            })

            ->name('Laporan_PSI '.now()->format('Y-m-d').'.pdf');
    }
}
