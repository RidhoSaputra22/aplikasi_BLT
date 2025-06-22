<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HasilPsiResource\Pages;
use App\Filament\Resources\HasilPsiResource\RelationManagers;
use App\Models\HasilPsi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HasilPsiResource extends Resource
{
    protected static ?string $model = HasilPsi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $pluralLabel = 'Hasil Perhitungan PSI';
    protected static ?string $singularLabel = 'Hasil Perhitungan PSI';

    protected static ?string $navigationGroup = 'PSI (Preference Selection Index)';


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('calon_penerima_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_preferensi')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('periode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListHasilPsis::route('/'),
            'create' => Pages\CreateHasilPsi::route('/create'),
            'edit' => Pages\EditHasilPsi::route('/{record}/edit'),
        ];
    }
}
