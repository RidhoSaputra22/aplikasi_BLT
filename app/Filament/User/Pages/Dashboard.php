<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Dashboard';

    public function getHeading(): string
    {
        return 'Dashboard';
    }
}
