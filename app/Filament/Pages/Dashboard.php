<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use App\Filament\Widgets\VoterStats;
use App\Filament\Widgets\FacultyChart;
use App\Filament\Widgets\VotingProgress;
use App\Filament\Widgets\RecentVoters;
use App\Filament\Widgets\ElectionResults;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            VoterStats::class,
            FacultyChart::class,
            VotingProgress::class,
            RecentVoters::class,
            ElectionResults::class,
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
        $logoUrl = asset('/images/iuea-logo.png');
        
        $actions = [
            Action::make('iueaLogo')
                ->label('')
                ->extraAttributes([
                    'style' => "background-image: url('{$logoUrl}'); background-size: contain; background-repeat: no-repeat; width: 44px; height: 44px;",
                ])
                ->url('https://iuea.ac.ug', shouldOpenInNewTab: true),
        ];
        
        // Only Super Admin can see Admin Management button
        if (auth()->user() && auth()->user()->isSuperAdmin()) {
            $actions[] = Action::make('manageAdmins')
                ->label('Manage Admins')
                ->icon('heroicon-o-user-group')
                ->color('primary')
                ->url('/admin/admin-users');
        }
        
        return $actions;
    }
}
