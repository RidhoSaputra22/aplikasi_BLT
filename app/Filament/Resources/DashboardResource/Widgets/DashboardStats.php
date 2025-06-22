<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{

    protected static ?int $int = 1;

    protected function getStats(): array
    {
        return [
            //
            Stat::make('Calon Penerima', \App\Models\CalonPenerima::count()),
            Stat::make('Layak Mendapatkan BLT', \App\Models\HasilPsi::where('status', 'Layak')->count()),
            Stat::make('Tidak Layak Mendapatkan BLT', \App\Models\HasilPsi::where('status', 'Tidak Layak')->count()),
        ];
    }
}
