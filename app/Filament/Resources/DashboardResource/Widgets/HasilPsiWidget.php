<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\CalonPenerima;
use App\Models\HasilPsi;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Artisan;

class HasilPsiWidget extends BaseWidget
{
    protected static ?string $heading = 'Hasil Perhitungan PSI (Preference Selection Index)';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\Action::make('Hitung Psi')
                    ->icon('heroicon-s-calculator')
                    ->color('primary')
                    ->action(function () {
                        Artisan::call('psi:hitung');

                        Notification::make()
                            ->title('Perhitungan PSI Selesai')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('Lihat Laporan')
                    ->icon('heroicon-s-document-text') // opsional: ikon lebih cocok
                    ->color('primary')
                    ->url(route('laporan.psi', ['dusun' => 'Semua']))
                    ->openUrlInNewTab(),
            ])

            // Jangan kunci sorting di query pakai orderByDesc
            ->query(
                HasilPsi::query()->with('calon_penerima')
            )
            // Default sort resmi dari Filament
            ->defaultSort('nilai_preferensi', 'desc')

            ->columns([
                Tables\Columns\TextColumn::make('calon_penerima.nama')
                    ->label('Nama Calon')
                    ->searchable()
                    // Sorting relasi: pakai query custom
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
                    // Kalau kolom numeric sudah benar di DB, sortable normal cukup:
                    ->sortable()
                // Kalau ternyata nilainya string di DB (sorting jadi aneh), pakai ini sebagai gantinya:
                // ->sortable(query: fn ($query, string $direction) =>
                //     $query->orderByRaw("CAST(nilai_preferensi AS DECIMAL(16,6)) $direction")
                // )
                ,

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
                    ->options(fn () => HasilPsi::query()->distinct()->orderBy('periode')->pluck('periode', 'periode')->toArray())
                    ->native(false)
                    ->placeholder('Semua Periode'),

                Tables\Filters\SelectFilter::make('status')
                    ->options(fn () => HasilPsi::query()->distinct()->orderBy('status')->pluck('status', 'status')->toArray())
                    ->native(false)
                    ->placeholder('Semua Status'),

                Tables\Filters\SelectFilter::make('calon_penerima_id')
                    ->options(fn () => CalonPenerima::query()->orderBy('nama')->pluck('nama', 'id')->toArray())
                    ->native(false)
                    ->label('Calon Penerima')
                    ->placeholder('Semua Calon Penerima'),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)

            ->filtersFormColumns(3);
    }
}
