<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use Filament\Tables;
use App\Models\HasilPsi;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Filament\Tables\Table;
use App\Models\CalonPenerima;
use App\Models\calon_penerima;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Filament\Widgets\TableWidget as BaseWidget;

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
                        Artisan::call('psi:hitung');
                        Notification::make()
                            ->title('Perhitungan PSI Selesai')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('Lihat Laporan')
                    ->icon('heroicon-s-calculator')
                    ->color('primary')
                    ->url(route('laporan.psi', ['dusun' => 'Semua']))
                    ->openUrlInNewTab(),
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
                    ->badge(fn($record) => $record->status)
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
            ->filtersFormColumns(3)
        ;
    }
}
