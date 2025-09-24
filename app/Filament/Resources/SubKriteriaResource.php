<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubKriteriaResource\Pages;
use App\Filament\Resources\SubKriteriaResource\RelationManagers;
use App\Models\SubKriteria;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class SubKriteriaResource extends Resource
{
    protected static ?string $model = SubKriteria::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $pluralLabel = 'Sub Kriteria Penerima BLT';
    protected static ?string $singularLabel = 'Sub Kriteria Penerima BLT';

    protected static ?string $navigationGroup = 'Kriteria';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kriteria_id')
                    ->label('Kriteria')
                    ->relationship('kriteria', 'nama_kriteria')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('nama_sub_kriteria')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bobot')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nama_sub_kriteria')
                    ->label('Sub Kriteria')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bobot')
                    ->numeric()
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
                Tables\Filters\SelectFilter::make('kriteria.nama_kriteria')
                    ->relationship('kriteria', 'nama_kriteria')
                    ->default(true),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultGroup(Tables\Grouping\Group::make('kriteria.nama_kriteria')->titlePrefixedWithLabel(false));
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
            'index' => Pages\ListSubKriterias::route('/'),
            'create' => Pages\CreateSubKriteria::route('/create'),
            'edit' => Pages\EditSubKriteria::route('/{record}/edit'),
        ];
    }
}
