<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoteResource\Pages;
use App\Models\Vote;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VoteResource extends Resource
{
    protected static ?string $model = Vote::class;
    protected static ?string $navigationGroup = 'Voting Management';
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'Votes (Results)';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('voter.voter_id')
                    ->label('Voter ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('candidate.display_name')
                    ->label('Candidate')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('sector')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('confirmed_at')
                    ->label('Confirmed At')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVotes::route('/'),
        ];
    }
}
