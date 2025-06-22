<?php

namespace App\Filament\Resources\HasilPsiResource\Pages;

use App\Filament\Resources\HasilPsiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHasilPsi extends EditRecord
{
    protected static string $resource = HasilPsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
