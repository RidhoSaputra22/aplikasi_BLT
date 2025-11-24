<?php

namespace App\Filament\User\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Penilaian;
use Filament\Tables\Table;
use App\Models\SubKriteria;
use App\Models\CalonPenerima;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PenilaianResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PenilaianResource\RelationManagers;

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
                Forms\Components\Select::make('dusun')
                    ->options(CalonPenerima::pluck('desa', 'desa')->unique())
                    ->native(false)
                    ->preload()
                    ->label('Dusun'),
                Forms\Components\Select::make('calon_penerima_id')
                    ->options(function (callable $get) {
                        $dusun = $get('dusun');
                        if ($dusun) {
                            return CalonPenerima::where('desa', $dusun)->pluck('nama', 'id');
                        }
                        return CalonPenerima::pluck('nama', 'id');
                    })
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->label('Nama Calon Penerima'),
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
                    ->disabled(fn(callable $get) => !$get('kriteria_id'))
                    ->options(function (callable $get) {
                        // return dd(SubKriteria::where('kriteria_id', $get('kriteria_id'))
                        //     ->pluck('nama_sub_kriteria', 'id'));
                        return (SubKriteria::where('kriteria_id', $get('kriteria_id'))
                            ->pluck('nama_sub_kriteria', 'id'));
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
