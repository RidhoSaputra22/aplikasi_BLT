<?php

namespace App\Filament\User\Resources\CalonPenerimaResource\Pages;

use App\Filament\User\Resources\CalonPenerimaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCalonPenerimas extends ListRecords
{
    protected static string $resource = CalonPenerimaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
