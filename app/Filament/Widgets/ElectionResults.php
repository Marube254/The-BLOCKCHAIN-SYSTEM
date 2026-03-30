<?php

namespace App\Filament\Widgets;

use App\Models\Candidate;
use App\Models\Vote;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class ElectionResults extends Widget
{
    protected static string $view = 'filament.widgets.election-results';
    protected static ?int $sort = 4;

    public function getResults()
    {
        return Candidate::withCount(['votes'])
            ->orderBy('votes_count', 'desc')
            ->get()
            ->groupBy('sector');
    }
}