<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', 'Total Users')
                ->description('Total number of users')
                ->value(User::where('role_id', 2)->count())
                ->icon('heroicon-o-users')
                ->color('success'),
        ];
    }
}
