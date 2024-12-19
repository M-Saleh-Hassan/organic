<?php

namespace App\Filament\Resources\LandResource\Widgets;

use App\Models\Land;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LandsCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Lands', 'Total Lands')
                ->description('Total number of lands')
                ->value(Land::count())
                ->icon('heroicon-o-map')
                ->color('success'),
        ];
    }
}
