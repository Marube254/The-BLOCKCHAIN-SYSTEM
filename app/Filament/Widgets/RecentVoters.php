<?php

namespace App\Filament\Widgets;

use App\Models\Voter;
use Filament\Widgets\TableWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class RecentVoters extends TableWidget
{
    protected static ?string $heading = 'Recent Registered Voters';
    protected static ?int $sort = 3;

    protected function getTableQuery(): Builder
    {
        return Voter::query()->latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('voter_id')
                ->label('Voter ID')
                ->searchable(),
            Tables\Columns\TextColumn::make('first_name')
                ->label('First Name')
                ->searchable(),
            Tables\Columns\TextColumn::make('last_name')
                ->label('Last Name'),
            Tables\Columns\TextColumn::make('email')
                ->label('Email'),
            Tables\Columns\BooleanColumn::make('has_voted')
                ->label('Voted'),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Registered')
                ->dateTime('d M Y'),
        ];
    }
}