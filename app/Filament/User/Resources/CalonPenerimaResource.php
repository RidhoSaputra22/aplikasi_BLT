<?php

namespace App\Filament\User\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CalonPenerima;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\User\Resources\CalonPenerimaResource\Pages;
use App\Filament\User\Resources\CalonPenerimaResource\RelationManagers;
use App\Filament\User\Resources\CalonPenerimaResource\RelationManagers\PenilaianRelationManager;

class CalonPenerimaResource extends Resource
{
    protected static ?string $model = CalonPenerima::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $pluralLabel = 'Calon Penerima BLT';
    protected static ?string $singularLabel = 'Calon Penerima BLT';

    protected static ?string $navigationGroup = 'Penerima';
    protected static ?int $sort = 1;


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->maxLength(16)
                    ->minLength(16)
                    ->numeric()
                    ->unique(ignoreRecord: true)
                    ->rule('digits:16'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('alamat')
                    ->options([
                        'Desa Lawaki Jaya' => 'Desa Lawaki Jaya',
                    ])
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('no_kk')
                    ->label('NO KK')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('desa')
                    ->label('Dusun')
                    ->options([
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_input')
                    ->label('Tanggal Input')
                    ->required()
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_kk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('desa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kabupaten')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_input')
                    ->date()
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
            'index' => Pages\ListCalonPenerimas::route('/'),
            'create' => Pages\CreateCalonPenerima::route('/create'),
            'edit' => Pages\EditCalonPenerima::route('/{record}/edit'),
        ];
    }
}
