<?php

namespace App\Http\Controllers;

use App\Models\HasilPsi;
use Spatie\LaravelPdf\Facades\Pdf;

class HasilPsiController extends Controller
{
    public function generatePdf($dusun)
    {
        if (empty($dusun)) abort(404, 'Dusun tidak boleh kosong.');

        $hasilPsiData = $dusun === 'Semua'
            ? HasilPsi::with('calon_penerima')->get()
            : HasilPsi::with('calon_penerima')
                ->whereHas('calon_penerima', fn ($q) => $q->where('desa', $dusun))
                ->get();

        $hasilPsi = $hasilPsiData->groupBy('calon_penerima.desa');

        return Pdf::view('pdf.laporan-psi', compact('hasilPsi'))
            ->format('A4')
            ->withBrowsershot(function ($browsershot) {

                // Deteksi OS
                $isWindows = strtoupper(substr(PHP_OS_FAMILY, 0, 3)) === 'WIN'; // atau: PHP_OS_FAMILY === 'Windows'
                // (opsional) kalau mau spesifik Linux:
                // $isLinux = PHP_OS_FAMILY === 'Linux';

                if ($isWindows) {
                    // Windows: biasanya pakai Chrome/Edge default install path (set via .env)
                    // Contoh .env:
                    // BROWSERSHOT_CHROME_PATH="C:\Program Files\Google\Chrome\Application\chrome.exe"
                    // atau Edge:
                    // BROWSERSHOT_CHROME_PATH="C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe"

                    $browsershot->setChromePath(env('BROWSERSHOT_CHROME_PATH'));

                    // args biasanya tidak perlu di Windows
                    $browsershot->addChromiumArguments([
                        '--disable-gpu',
                    ]);
                } else {
                    // Linux: biasanya chromium/chrome + perlu sandbox flags di server/container
                    // Contoh .env:
                    // BROWSERSHOT_CHROME_PATH=/usr/bin/chromium-browser
                    // atau /usr/bin/chromium atau /usr/bin/google-chrome

                    $browsershot->setChromePath(env('BROWSERSHOT_CHROME_PATH'));

                    $browsershot->addChromiumArguments([
                        '--no-sandbox',
                        '--disable-setuid-sandbox',
                        '--disable-dev-shm-usage',
                    ]);
                }

                // Margin yang pasti (mm), biar konsisten
                $browsershot->margins('4mm', '4mm', '3mm', '3mm');

                // Kalau perlu print background:
                // $browsershot->showBackground();
            })
            ->name('Laporan_PSI ' . now()->format('Y-m-d') . '.pdf');
    }
}
