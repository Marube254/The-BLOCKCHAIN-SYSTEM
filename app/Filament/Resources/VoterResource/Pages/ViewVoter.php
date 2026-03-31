<?php

namespace App\Filament\Resources\VoterResource\Pages;

use App\Filament\Resources\VoterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVoter extends ViewRecord
{
    protected static string $resource = VoterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('vote')
                ->label('Cast Vote')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => !$this->record->has_voted)
                ->url(fn () => VoterResource::getUrl('voting', ['record' => $this->record])),
        ];
    }
}
