<?php

namespace App\Filament\Resources\HasilPsiResource\Pages;

use App\Filament\Resources\HasilPsiResource;
use App\Models\HasilPsi;
use App\Services\HasilPsiService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListHasilPsis extends ListRecords
{
    protected static string $resource = HasilPsiResource::class;

    protected function getHeaderActions(): array
    {

        $opsiLaporan = HasilPsi::with('calon_penerima')
            ->get()
            ->pluck('calon_penerima.desa', 'calon_penerima.desa')
            ->unique()
            ->toArray();
        // tambah lihat semua
        $opsiLaporan['Semua'] = 'Semua';

        return [
            Action::make('Hitung Psi')
                ->icon('heroicon-s-calculator')
                ->color('primary')
                ->action(function () {
                    app(HasilPsiService::class)->hitung();
                    Notification::make()
                        ->title('Perhitungan PSI Selesai')
                        ->success()
                        ->send();
                }),

            Action::make('Lihat Laporan')
                ->icon('heroicon-s-document-text')
                ->color('primary')
                ->modalHeading('Laporan Hasil Perhitungan PSI')
                ->modalDescription('Pilih dusun untuk melihat laporan hasil perhitungan PSI.')
                ->form([
                    Select::make('dusun')
                        ->label('Dusun')
                        ->options(
                            $opsiLaporan
                        )
                        ->required(),
                ])
                ->action(function ($data) {
                    $dusun = $data['dusun'];
                    $url = route('laporan.psi', ['dusun' => $dusun]);

                    return redirect($url);
                })
                ->openUrlInNewTab(),
        ];
    }
}
