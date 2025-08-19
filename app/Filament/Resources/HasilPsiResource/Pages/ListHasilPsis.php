<?php

namespace App\Filament\Resources\HasilPsiResource\Pages;

use App\Models\HasilPsi;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\HasilPsiResource;

class ListHasilPsis extends ListRecords
{
    protected static string $resource = HasilPsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Hitung Psi')
                ->icon('heroicon-s-calculator')
                ->color('primary')
                ->action(function () {
                    Artisan::call('psi:hitung');
                    Notification::make()
                        ->title('Perhitungan PSI Selesai')
                        ->success()
                        ->send();
                }),

            Action::make('Lihat Laporan')
                ->icon('heroicon-s-calculator')
                ->color('primary')
                ->url(route('laporan.psi'))
                ->openUrlInNewTab()
        ];
    }
}
