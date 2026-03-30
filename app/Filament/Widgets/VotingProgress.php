<?php

namespace App\Filament\Widgets;

use App\Models\Voter;
use App\Models\Vote;
use Filament\Widgets\ChartWidget;

class VotingProgress extends ChartWidget
{
    protected static ?string $heading = 'Voting Progress by Faculty';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $faculties = Voter::whereNotNull('faculty')
            ->select('faculty')
            ->distinct()
            ->pluck('faculty')
            ->toArray();

        $votedCounts = [];
        $totalCounts = [];

        foreach ($faculties as $faculty) {
            $total = Voter::where('faculty', $faculty)->count();
            $voted = Voter::where('faculty', $faculty)->where('has_voted', true)->count();
            
            $totalCounts[] = $total;
            $votedCounts[] = $voted;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Voted',
                    'data' => $votedCounts,
                    'backgroundColor' => '#8B0000',
                    'borderColor' => '#8B0000',
                ],
                [
                    'label' => 'Total Registered',
                    'data' => $totalCounts,
                    'backgroundColor' => '#e5e7eb',
                    'borderColor' => '#9ca3af',
                ],
            ],
            'labels' => $faculties,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}