<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Models\Candidate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;

class CandidateResource extends Resource
{
    protected static ?string $model = Candidate::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Candidates';
    protected static ?string $navigationGroup = 'Voting Management';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Candidate Information')
                ->schema([
                    Forms\Components\TextInput::make('candidate_id')
                        ->label('Candidate ID')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('first_name')->required(),
                    Forms\Components\TextInput::make('last_name')->required(),
                    Forms\Components\TextInput::make('display_name')->required(),

                    Forms\Components\FileUpload::make('photo_filename')
                        ->label('Candidate Photo')
                        ->image()
                        ->directory('candidate-photos')
                        ->downloadable()
                        ->previewable()
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Position Details')
                ->schema([
                    Forms\Components\Select::make('sector')
                        ->options([
                            'Guild President' => 'Guild President',
                            'Vice President' => 'Vice President',
                            'General Secretary' => 'General Secretary',
                            'Finance Minister' => 'Finance Minister',
                            'Sports Minister' => 'Sports Minister',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('sector_code')->required(),

                    Forms\Components\TextInput::make('candidate_number')
                        ->numeric()
                        ->required(),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('photo_filename')
                    ->label('Photo')
                    ->disk('public')
                    ->square()
                    ->size(45),

                TextColumn::make('display_name')->searchable()->sortable(),
                TextColumn::make('sector')->sortable(),

                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'withdrawn',
                        'danger'  => 'disqualified',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCandidates::route('/'),
            'create' => Pages\CreateCandidate::route('/create'),
            'edit'   => Pages\EditCandidate::route('/{record}/edit'),
        ];
    }
}
