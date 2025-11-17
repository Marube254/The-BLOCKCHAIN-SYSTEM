<?php

namespace App\Filament\Widgets;

use App\Models\Voter;
use Filament\Widgets\ChartWidget;

class FacultyChart extends ChartWidget
{
    protected static ?string $heading = 'Voters by Faculty';

    // Auto-refresh every 15 seconds
    protected static ?string $pollingInterval = '15s';

    protected function getData(): array
    {
        // Group voters by faculty and count them
        $data = Voter::selectRaw('faculty, COUNT(*) as total')
            ->groupBy('faculty')
            ->pluck('total', 'faculty');

        return [
            'datasets' => [
                [
                    'label' => 'Voters per Faculty',
                    'data' => $data->values(),
                    'backgroundColor' => [
                        '#10B981', // Green
                        '#3B82F6', // Blue
                        '#F59E0B', // Yellow
                        '#EF4444', // Red
                    ],
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // You can change to 'bar' or 'doughnut'
    }
}
