<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenilaianResource\Pages;
use App\Models\CalonPenerima;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenilaianResource extends Resource
{
    protected static ?string $model = Penilaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $pluralLabel = 'Penilaian Calon Penerima BLT';

    protected static ?string $singularLabel = 'Penilaian Calon Penerima BLT';

    protected static ?string $navigationGroup = 'PSI (Preference Selection Index)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('calon_penerima_id')
                    ->label('NIK / Nama Calon Penerima')
                    ->searchable()
                    ->native(false)
                    ->preload()
                    ->reactive()
                    ->getSearchResultsUsing(function (string $search) {
                        return CalonPenerima::where('nik', 'like', "%{$search}%")
                            ->orWhere('nama', 'like', "%{$search}%")
                            ->limit(20)
                            ->get()
                            ->mapWithKeys(fn ($item) => [
                                $item->id => "{$item->nik} — {$item->nama}",
                            ])
                            ->toArray();
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $cp = CalonPenerima::find($value);

                        return $cp ? "{$cp->nik} — {$cp->nama}" : $value;
                    })
                    ->afterStateUpdated(function ($state, callable $set) {
                        $cp = CalonPenerima::find($state);
                        $set('dusun_display', $cp?->desa ?? '');
                    })
                    ->placeholder('Ketik NIK atau nama calon penerima...')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('dusun_display')
                    ->label('Dusun')
                    ->readOnly()
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Otomatis terisi setelah pilih calon penerima')
                    ->afterStateHydrated(function ($component, $state, callable $get) {
                        $cp = CalonPenerima::find($get('calon_penerima_id'));
                        $component->state($cp?->desa ?? '');
                    })
                    ->columnSpanFull(),
                Forms\Components\Select::make('kriteria_id')
                    ->required()
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->relationship('kriteria', 'nama_kriteria')
                    ->reactive(),
                Forms\Components\Select::make('sub_kriteria_id')
                    ->required()
                    ->native(false)
                    ->reactive()
                    ->disabled(fn (callable $get) => ! $get('kriteria_id'))
                    ->options(function (callable $get) {
                        // return dd(SubKriteria::where('kriteria_id', $get('kriteria_id'))
                        //     ->pluck('nama_sub_kriteria', 'id'));
                        return SubKriteria::where('kriteria_id', $get('kriteria_id'))
                            ->pluck('nama_sub_kriteria', 'id');
                    })
                    ->label('Sub Kriteria'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calonPenerima.nama')
                    ->sortable()
                    ->searchable()
                    ->label('Nama Calon Penerima'),
                Tables\Columns\TextColumn::make('kriteria.nama_kriteria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subKriteria.nama_sub_kriteria')
                    ->label('Sub Kriteria')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subKriteria.bobot')
                    ->label('Bobot')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('calon_penerima_id')
                    ->relationship('calonPenerima', 'nama')
                    ->label('Nama Calon Penerima')
                    ->default()
                    ->native(false)
                    ->preload()
                    ->searchable(),

                Tables\Filters\SelectFilter::make('kriteria_id')
                    ->relationship('kriteria', 'nama_kriteria')
                    ->native(false)
                    ->preload()
                    ->searchable(),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenilaians::route('/'),
            'create' => Pages\CreatePenilaian::route('/create'),
            'edit' => Pages\EditPenilaian::route('/{record}/edit'),
        ];
    }
}
