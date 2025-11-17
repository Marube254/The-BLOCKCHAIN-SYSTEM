<?php

namespace App\Filament\Widgets;

use App\Models\Voter;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VoterStats extends StatsOverviewWidget
{
    // Auto-refresh every 10 seconds (string format)
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Voters', Voter::count())
                ->description('All registered voters')
                ->color('success')
                ->icon('heroicon-o-user-group'),

            Stat::make('Voters Who Have Voted', Voter::where('has_voted', true)->count())
                ->description('Already cast their vote')
                ->color('info')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Pending Voters', Voter::where('has_voted', false)->count())
                ->description('Still to participate')
                ->color('warning')
                ->icon('heroicon-o-clock'),
        ];
    }
}
