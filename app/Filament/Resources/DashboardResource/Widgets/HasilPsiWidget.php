<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\calon_penerima;
use App\Models\HasilPsi;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HasilPsiWidget extends BaseWidget
{
    protected static ?string $heading = 'Hasil Perhitungan PSI (Preference Selection Index)';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {

        return $table
            ->headerActions([
                Tables\Actions\Action::make('Hitung Psi')
                    ->icon('heroicon-s-calculator')
                    ->color('primary')
                    ->action(function () {
                        HasilPsi::calculate();
                    })
            ])
            ->query(
                HasilPsi::with('calon_penerima')->orderByDesc('nilai_preferensi')
            )
            ->columns([
                Tables\Columns\TextColumn::make('calon_penerima.nama')
                    ->label('Nama Calon')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nilai_preferensi')
                    ->label('Skor Preferensi')
                    ->sortable()
                    ->numeric(4),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'Layak',
                        'danger' => 'Tidak Layak',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('periode')
                    ->label('Periode')
                    ->sortable(),
            ]);
    }
}
