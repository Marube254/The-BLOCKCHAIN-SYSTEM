<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoterResource\Pages;
use App\Models\Voter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VoterResource extends Resource
{
    protected static ?string $model = Voter::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Voters';
    protected static ?string $navigationGroup = 'Election Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('voter_id')
                            ->label('Voter ID')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Academic Information')
                    ->schema([
                        Forms\Components\TextInput::make('faculty')
                            ->label('Faculty')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('faculty_code')
                            ->label('Faculty Code')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('program')
                            ->label('Program')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('year_of_study')
                            ->label('Year of Study')
                            ->maxLength(50),
                    ])->columns(2),

                Forms\Components\Section::make('Voting Status')
                    ->schema([
                        Forms\Components\Toggle::make('has_voted')
                            ->label('Has Voted')
                            ->disabled()
                            ->helperText('Voting status is automatically updated when vote is cast'),
                        Forms\Components\DateTimePicker::make('voted_at')
                            ->label('Voted At')
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('voter_id')
                    ->label('Voter ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Voter ID copied'),
                
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope'),
                
                Tables\Columns\TextColumn::make('faculty')
                    ->label('Faculty')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('program')
                    ->label('Program')
                    ->searchable()
                    ->toggleable()
                    ->limit(30),
                
                Tables\Columns\IconColumn::make('has_voted')
                    ->label('Voted')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('voted_at')
                    ->label('Voted At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('has_voted')
                    ->label('Voting Status')
                    ->options([
                        '1' => 'Has Voted',
                        '0' => 'Not Voted Yet',
                    ])
                    ->placeholder('All Voters'),
                
                Tables\Filters\SelectFilter::make('faculty')
                    ->label('Faculty')
                    ->options(Voter::distinct()->pluck('faculty', 'faculty')->filter())
                    ->placeholder('All Faculties'),
                
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('registered_from')
                            ->label('Registered From'),
                        Forms\Components\DatePicker::make('registered_until')
                            ->label('Registered Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['registered_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['registered_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('vote')
                    ->label('Vote')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => !$record->has_voted)
                    ->url(fn ($record): string => VoterResource::getUrl('voting', ['record' => $record])),
                    
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye'),
                    
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),
                    
                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('mark_voted')
                    ->label('Mark as Voted')
                    ->icon('heroicon-o-check')
                    ->action(function ($records) {
                        foreach ($records as $record) {
                            $record->update(['has_voted' => true]);
                        }
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('10s');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVoters::route('/'),
            'create' => Pages\CreateVoter::route('/create'),
            'edit' => Pages\EditVoter::route('/{record}/edit'),
            'view' => Pages\ViewVoter::route('/{record}'),
            'voting' => Pages\VotingPage::route('/{record}/vote'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $total = static::getModel()::count();
        $voted = static::getModel()::where('has_voted', true)->count();
        
        if ($total > 0) {
            return $voted . '/' . $total;
        }
        
        return null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $total = static::getModel()::count();
        $voted = static::getModel()::where('has_voted', true)->count();
        
        if ($total === 0) return 'gray';
        if ($voted === $total) return 'success';
        if ($voted > 0) return 'warning';
        return 'danger';
    }
}
