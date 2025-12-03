<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Models\Candidate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CandidateResource extends Resource
{
    protected static ?string $model = Candidate::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Candidates';
    protected static ?string $navigationGroup = 'Voting Management';

    /**
     * Candidate Form
     */
    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Candidate Information')
                ->schema([
                    Forms\Components\TextInput::make('candidate_id')
                        ->label('Candidate ID')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('first_name')
                        ->required(),

                    Forms\Components\TextInput::make('last_name')
                        ->required(),

                    Forms\Components\TextInput::make('display_name')
                        ->label('Display Name')
                        ->required(),

                    Forms\Components\FileUpload::make('photo_filename')
                        ->label('Candidate Photo')
                        ->image()
                        ->directory('candidate-photos')
                        ->imagePreviewHeight(150)
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Academic Details')
                ->schema([
                    Forms\Components\Select::make('faculty')
                        ->required()
                        ->options([
                            'Business' => 'Business',
                            'Engineering' => 'Engineering',
                            'Science and Technology' => 'Science and Technology',
                        ]),

                    Forms\Components\TextInput::make('faculty_code')
                        ->required(),

                    Forms\Components\TextInput::make('program')
                        ->required(),

                    Forms\Components\TextInput::make('year_of_study')
                        ->numeric()
                        ->required(),
                ])
                ->columns(4),

            Forms\Components\Section::make('Sector Details')
                ->schema([
                    Forms\Components\Select::make('sector')
                        ->label('Position / Sector')
                        ->required()
                        ->options([
                            'Guild President' => 'Guild President',
                            'Vice President' => 'Vice President',
                            'General Secretary' => 'General Secretary',
                            'Finance Minister' => 'Finance Minister',
                            'Sports Minister' => 'Sports Minister',
                        ]),

                    Forms\Components\TextInput::make('sector_code')
                        ->required(),

                    Forms\Components\TextInput::make('candidate_number')
                        ->numeric()
                        ->required()
                        ->unique(ignoreRecord: true),
                ])
                ->columns(3),

            Forms\Components\Section::make('Additional Information')
                ->schema([
                    Forms\Components\Textarea::make('manifesto')
                        ->rows(4),

                    Forms\Components\Textarea::make('bio')
                        ->label('Short Bio')
                        ->rows(3),

                    Forms\Components\TextInput::make('contact_email')
                        ->email(),

                    Forms\Components\Select::make('status')
                        ->required()
                        ->options([
                            'active' => 'Active',
                            'withdrawn' => 'Withdrawn',
                            'disqualified' => 'Disqualified',
                        ])
                        ->default('active'),

                    Forms\Components\DateTimePicker::make('registered_at')
                        ->label('Registration Time'),
                ])
                ->columns(2),
        ]);
    }

    /**
     * Candidate Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('photo_filename')
                    ->label('Photo')
                    ->square()
                    ->size(50)
                    ->disk('public')
                    ->visibility('public'),

                Tables\Columns\TextColumn::make('candidate_id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('display_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('faculty')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('sector')->sortable()->searchable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'withdrawn',
                        'danger'  => 'disqualified',
                    ]),

                Tables\Columns\TextColumn::make('registered_at')
                    ->label('Registered At')
                    ->dateTime('d M Y H:i'),
            ])
            ->defaultSort('display_name')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index'  => Pages\ListCandidates::route('/'),
            'create' => Pages\CreateCandidate::route('/create'),
            'edit'   => Pages\EditCandidate::route('/{record}/edit'),
        ];
    }
}
