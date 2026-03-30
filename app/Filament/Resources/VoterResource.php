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
use Illuminate\Database\Eloquent\Builder;

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
                Tables\Columns\TextColumn::make('voter_id')
                    ->label('Voter ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('faculty')
                    ->label('Faculty'),
                Tables\Columns\BooleanColumn::make('has_voted')
                    ->label('Voted')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
                Tables\Columns\TextColumn::make('voted_at')
                    ->label('Voted At')
                    ->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('d M Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('faculty')
                    ->options(Voter::distinct()->pluck('faculty', 'faculty')),
                Tables\Filters\Filter::make('has_voted')
                    ->label('Voted')
                    ->query(fn (Builder $query): Builder => $query->where('has_voted', true)),
                Tables\Filters\Filter::make('not_voted')
                    ->label('Not Voted')
                    ->query(fn (Builder $query): Builder => $query->where('has_voted', false)),
            ])
            ->actions([
                Tables\Actions\Action::make('vote')
                    ->label('Vote')
                    ->icon('heroicon-o-check-circle')
                    ->color('primary')
                    ->url(fn (Voter $record): string => VoterResource::getUrl('voting', ['record' => $record])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'voting' => Pages\VotingPage::route('/{record}/voting'),
        ];
    }
}
