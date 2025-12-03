<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoterResource\Pages;
use App\Models\Voter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class VoterResource extends Resource
{
    protected static ?string $model = Voter::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Voters';
    protected static ?string $navigationGroup = 'Voting Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('voter_id')
                ->required()
                ->unique(Voter::class, 'voter_id', ignoreRecord: true)
                ->placeholder('e.g., V001'),

            Forms\Components\TextInput::make('first_name')->required(),
            Forms\Components\TextInput::make('last_name')->required(),

            Forms\Components\Select::make('faculty')
                ->options([
                    'Business' => 'Business',
                    'Engineering' => 'Engineering',
                    'Science and Technology' => 'Science and Technology',
                ])
                ->required(),

            Forms\Components\TextInput::make('faculty_code')->required(),
            Forms\Components\TextInput::make('program')->required(),

            Forms\Components\TextInput::make('year_of_study')
                ->numeric()
                ->required(),

            Forms\Components\DateTimePicker::make('registered_at')
                ->default(now())
                ->required(),

            Forms\Components\Toggle::make('has_voted')
                ->label('Has Voted')
                ->disabled()
                ->helperText('Automatically updates after voting.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('voter_id')->sortable()->searchable(),
                TextColumn::make('first_name')->sortable()->searchable(),
                TextColumn::make('last_name')->sortable()->searchable(),
                TextColumn::make('faculty')->sortable()->searchable(),

                IconColumn::make('has_voted')
                    ->label('Voted?')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('faculty')->options([
                    'Business' => 'Business',
                    'Engineering' => 'Engineering',
                    'Science and Technology' => 'Science and Technology',
                ]),
                Tables\Filters\TernaryFilter::make('has_voted')->label('Voted'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('vote')
                    ->icon('heroicon-o-finger-print')
                    ->color('success')
                    ->label('Vote')
                    ->url(fn ($record) => Pages\VotingPage::getUrl(['record' => $record])),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVoters::route('/'),
            'create' => Pages\CreateVoter::route('/create'),
            'edit' => Pages\EditVoter::route('/{record}/edit'),
            'voting' => Pages\VotingPage::route('/{record}/voting'),
        ];
    }
}
