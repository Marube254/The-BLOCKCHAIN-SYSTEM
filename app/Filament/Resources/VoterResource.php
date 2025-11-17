<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoterResource\Pages;
use App\Models\Voter;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

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
                ->unique(ignoreRecord: true)
                ->placeholder('e.g., V1'),

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
                ->required()
                ->default(now()),

            Forms\Components\Toggle::make('has_voted')
                ->label('Has Voted')
                ->default(false),

            Forms\Components\TextInput::make('fingerprint_template_id')
                ->label('Fingerprint Template ID'),
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
                BadgeColumn::make('has_voted')
                    ->label('Voted?')
                    ->colors([
                        'success' => fn ($state) => $state === true,
                        'secondary' => fn ($state) => $state === false,
                    ]),
                TextColumn::make('registered_at')->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('faculty')
                    ->options([
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
                    ->label('Vote')
                    ->color('success')
                    ->icon('heroicon-o-finger-print')
                    ->url(fn ($record) => static::getUrl('vote', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVoters::route('/'),
            'create' => Pages\CreateVoter::route('/create'),
            'edit' => Pages\EditVoter::route('/{record}/edit'),
            'vote' => Pages\VoteScreen::route('/{record}/vote'), // Custom fingerprint voting page
        ];
    }
}
