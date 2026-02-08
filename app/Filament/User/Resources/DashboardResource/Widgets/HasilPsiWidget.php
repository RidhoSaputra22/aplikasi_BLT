<?php

namespace App\Filament\User\Resources\DashboardResource\Widgets;

use App\Models\CalonPenerima;
use App\Models\HasilPsi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HasilPsiWidget extends BaseWidget
{
    protected static ?string $heading = 'Hasil Perhitungan PSI (Preference Selection Index)';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([

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
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge(fn ($record) => $record->status)
                    ->sortable()
                    ->colors([
                        'success' => 'Layak',
                        'danger' => 'Tidak Layak',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('periode')
                    ->label('Periode')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('periode')
                    ->options(
                        HasilPsi::distinct()->pluck('periode', 'periode')->toArray()
                    )
                    ->native(false)
                    ->placeholder('Semua Periode'),
                Tables\Filters\SelectFilter::make('status')
                    ->options(
                        HasilPsi::distinct()->pluck('status', 'status')->toArray()
                    )
                    ->native(false)
                    ->placeholder('Semua Status'),
                Tables\Filters\SelectFilter::make('calon_penerima_id')
                    ->options(
                        CalonPenerima::orderBy('nama')
                            ->pluck('nama', 'id')
                            ->toArray()
                    )
                    ->native(false)
                    ->label('Calon Penerima')
                    ->placeholder('Semua Calon Penerima'),

            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(3);
    }
}
