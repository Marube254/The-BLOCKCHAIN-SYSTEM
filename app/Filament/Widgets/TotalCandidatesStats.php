<?php

namespace App\Filament\Widgets;

use App\Models\Candidate;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalCandidatesStats extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Candidates', Candidate::count())
                ->description('All registered candidates')
                ->color('primary')
                ->icon('heroicon-o-user'),

            Stat::make('Active Candidates', Candidate::where('status', 'active')->count())
                ->description('Currently active')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Inactive Candidates', Candidate::where('status', '!=', 'active')->count())
                ->description('Not active')
                ->color('danger')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
