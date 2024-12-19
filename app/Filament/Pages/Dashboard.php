<?php

namespace App\Filament\Pages;

use App\Filament\Resources\LandResource\Widgets\LandsCount;
use App\Filament\Resources\UserResource\Widgets\UsersCount;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
        //    'Filament\Widgets\AccountWidget',
           UsersCount::class,
           LandsCount::class
        ];
    }
}
