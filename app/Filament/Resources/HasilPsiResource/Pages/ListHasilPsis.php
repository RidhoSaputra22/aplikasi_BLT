<?php

namespace App\Filament\Resources\HasilPsiResource\Pages;

use App\Filament\Resources\HasilPsiResource;
use App\Models\HasilPsi;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

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
                    HasilPsi::calculate();
                })
        ];
    }
}
