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
                // kosong
            ])

            // Jangan kunci sorting pakai orderByDesc di query
            ->query(HasilPsi::query()->with('calon_penerima'))

            // Default sort yang benar (Filament-friendly)
            ->defaultSort('nilai_preferensi', 'desc')

            ->columns([
                Tables\Columns\TextColumn::make('calon_penerima.nama')
                    ->label('Nama Calon')
                    ->searchable()
                    // Sorting relasi perlu query custom biar beneran jalan
                    ->sortable(query: function ($query, string $direction) {
                        $query->orderBy(
                            CalonPenerima::select('nama')
                                ->whereColumn('calon_penerimas.id', 'hasil_psis.calon_penerima_id'),
                            $direction
                        );
                    }),

                Tables\Columns\TextColumn::make('nilai_preferensi')
                    ->label('Skor Preferensi')
                    ->numeric(4)
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    // FIX: badge() tanpa closure
                    ->badge()
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
                    ->options(fn () => HasilPsi::query()
                        ->distinct()
                        ->orderBy('periode')
                        ->pluck('periode', 'periode')
                        ->toArray()
                    )
                    ->native(false)
                    ->placeholder('Semua Periode'),

                Tables\Filters\SelectFilter::make('status')
                    ->options(fn () => HasilPsi::query()
                        ->distinct()
                        ->orderBy('status')
                        ->pluck('status', 'status')
                        ->toArray()
                    )
                    ->native(false)
                    ->placeholder('Semua Status'),

                Tables\Filters\SelectFilter::make('calon_penerima_id')
                    ->options(fn () => CalonPenerima::query()
                        ->orderBy('nama')
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
