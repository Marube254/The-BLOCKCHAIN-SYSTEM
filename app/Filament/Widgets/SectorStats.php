<?php

namespace App\Filament\Widgets;

use App\Models\Sector;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SectorStats extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Sectors', Sector::count())
                ->description('All sectors in the platform')
                ->color('primary')
                ->icon('heroicon-o-x-circle'),

            Stat::make('Guild Sectors', Sector::where('sector_code', 'like', 'G%')->count())
                ->description('Guild-level sectors')
                ->color('info')
                ->icon('heroicon-o-briefcase'),

            Stat::make('Other Sectors', Sector::where('sector_code', 'not like', 'G%')->count())
                ->description('Other categories')
                ->color('secondary')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
