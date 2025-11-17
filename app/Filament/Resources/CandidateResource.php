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

                    Forms\Components\TextInput::make('first_name')->required(),
                    Forms\Components\TextInput::make('last_name')->required(),
                    Forms\Components\TextInput::make('display_name')->required(),

                    Forms\Components\FileUpload::make('photo_filename')
                        ->label('Candidate Photo')
                        ->image()
                        ->directory('candidate-photos')
                        ->imagePreviewHeight('150'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Academic Details')
                ->schema([
                    Forms\Components\Select::make('faculty')
                        ->options([
                            'Business' => 'Business',
                            'Engineering' => 'Engineering',
                            'Science and Technology' => 'Science and Technology',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('faculty_code')->required(),
                   // Forms\Components\TextInput::make('department')->required(),
                    Forms\Components\TextInput::make('program')->required(),
                    Forms\Components\TextInput::make('year_of_study')->numeric()->required(),
                ])
                ->columns(3),

            Forms\Components\Section::make('Sector Details')
                ->schema([
                    Forms\Components\Select::make('sector')
                        ->options([
                            'Guild President' => 'Guild President',
                            'Vice President' => 'Vice President',
                            'General Secretary' => 'General Secretary',
                            'Finance Minister' => 'Finance Minister',
                            'Sports Minister' => 'Sports Minister',
                        ])
                        ->label('Sector / Position')
                        ->required(),

                    Forms\Components\TextInput::make('sector_code')
                        ->required()
                        ->label('Sector Code'),

                    Forms\Components\TextInput::make('candidate_number')
                        ->numeric()
                        ->required()
                        ->label('Candidate Number'),
                ])
                ->columns(3),

            Forms\Components\Section::make('Additional Info')
                ->schema([
                    Forms\Components\Textarea::make('manifesto')
                        ->rows(3)
                        ->label('Manifesto'),

                    Forms\Components\Textarea::make('bio')
                        ->rows(3)
                        ->label('Short Bio'),

                    Forms\Components\TextInput::make('contact_email')
                        ->email()
                        ->label('Contact Email'),

                    Forms\Components\Select::make('status')
                        ->options([
                            'active' => 'Active',
                            'withdrawn' => 'Withdrawn',
                            'disqualified' => 'Disqualified',
                        ])
                        ->default('active')
                        ->required(),

                    Forms\Components\DateTimePicker::make('registered_at')
                        ->label('Registration Date'),

                   /* Forms\Components\Textarea::make('metadata')
                        ->helperText('Optional JSON metadata (e.g., created_by, photo_hash, QR payload)'),*/
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
                ImageColumn::make('photo_filename')
                    ->label('Photo')
                    ->square()
                    ->size(45),

                TextColumn::make('candidate_id')->sortable()->searchable(),
                TextColumn::make('display_name')->sortable()->searchable(),
                TextColumn::make('faculty')->sortable()->searchable(),
                TextColumn::make('sector')->sortable()->searchable(),

                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'withdrawn',
                        'danger'  => 'disqualified',
                    ])
                    ->label('Status'),

                TextColumn::make('registered_at')
                    ->dateTime('d M Y H:i')
                    ->label('Registered At'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('faculty')
                    ->options([
                        'Business' => 'Business',
                        'Engineering' => 'Engineering',
                        'Science and Technology' => 'Science and Technology',
                    ]),
                Tables\Filters\SelectFilter::make('sector')
                    ->options([
                        'Guild President' => 'Guild President',
                        'Vice President' => 'Vice President',
                        'General Secretary' => 'General Secretary',
                        'Finance Minister' => 'Finance Minister',
                        'Sports Minister' => 'Sports Minister',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'withdrawn' => 'Withdrawn',
                        'disqualified' => 'Disqualified',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * Candidate Pages
     */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCandidates::route('/'),
            'create' => Pages\CreateCandidate::route('/create'),
            'edit'   => Pages\EditCandidate::route('/{record}/edit'),
        ];
    }

}
