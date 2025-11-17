<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use App\Filament\Widgets\VoterStats;
use App\Filament\Widgets\FacultyChart;
use App\Filament\Widgets\VotingProgress;

class Dashboard extends BaseDashboard
{
    /**
     * Define dashboard widgets.
     */
    public function getWidgets(): array
    {
        return [
            //VoterStats::class,
           // FacultyChart::class,
            // VotingProgress::class,
        ];
    }

    /**
     * Remove Filament’s default footer widgets (this removes GitHub promo).
     */
    protected function getFooterWidgets(): array
    {
        return [];
    }

    /**
     * Control the layout columns (optional).
     */
    public function getColumns(): int | array
    {
        return 2;
    }

    /**
     * Add a header action showing the IUEA logo (clickable).
     *
     * Note: Put your logo image at public/images/iuea-logo.png (or adjust the path below).
     */
    protected function getHeaderActions(): array
    {
        // Use asset() to point to the logo file in public/
        $logoUrl = asset('/images/iuea.jfif');

        return [
            Action::make('iueaLogo')
                ->label('') // no text label — we show the logo as the action
                ->icon('') // no icon
                ->extraAttributes([
                    // classes for spacing and alignment
                    'class' => 'filament-iuea-logo-wrapper',
                    // ARIA, accessible name
                    'aria-label' => 'IUEA',
                    'title' => 'International University of East Africa',
                    // inline style — background image is used to render the logo
                    'style' => "background-image: url('{$logoUrl}'); background-size: contain; background-repeat: no-repeat; width: 44px; height: 44px; display: inline-block; border-radius: 6px;",
                ])
                ->url('https://iuea.ac.ug', shouldOpenInNewTab: true),
        ];
    }
}
