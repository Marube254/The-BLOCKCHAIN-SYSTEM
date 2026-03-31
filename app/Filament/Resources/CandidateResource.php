<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Models\Candidate;
use App\Models\Sector;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class CandidateResource extends Resource
{
    protected static ?string $model = Candidate::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Candidates';
    protected static ?string $navigationGroup = 'Election Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Candidate Information')
                    ->schema([
                        Forms\Components\TextInput::make('display_name')
                            ->label('Candidate Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('sector')
                            ->label('Sector')
                            ->required()
                            ->options(function () {
                                return Sector::whereNotNull('sector_code')
                                    ->pluck('sector_name', 'sector_code')
                                    ->toArray();
                            })
                            ->searchable(),

                        Forms\Components\FileUpload::make('photo_filename')
                            ->label('Candidate Photo')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('200')
                            ->imageResizeTargetHeight('200')
                            ->directory('candidate-photos')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->helperText('Upload a professional photo (square image recommended, max 2MB)')
                            ->columnSpanFull(),
                        
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('removeImage')
                                ->label('Remove Current Image')
                                ->color('danger')
                                ->icon('heroicon-o-trash')
                                ->visible(fn ($record) => $record && ($record->photo_filename || $record->photo_path))
                                ->requiresConfirmation()
                                ->action(function ($record) {
                                    try {
                                        if ($record->photo_filename) {
                                            Storage::disk('public')->delete($record->photo_filename);
                                        }
                                        if ($record->photo_path) {
                                            Storage::disk('public')->delete($record->photo_path);
                                        }
                                        $record->update(['photo_filename' => null, 'photo_path' => null]);
                                        
                                        Notification::make()
                                            ->title('Image removed successfully')
                                            ->success()
                                            ->send();
                                    } catch (\Exception $e) {
                                        Notification::make()
                                            ->title('Failed to remove image')
                                            ->body($e->getMessage())
                                            ->danger()
                                            ->send();
                                    }
                                }),
                        ])->columnSpanFull(),

                        Forms\Components\Textarea::make('bio')
                            ->label('Biography')
                            ->maxLength(500)
                            ->rows(3)
                            ->helperText('Brief background of the candidate'),

                        Forms\Components\Textarea::make('manifesto')
                            ->label('Manifesto')
                            ->maxLength(1000)
                            ->rows(5)
                            ->helperText('Campaign promises and goals'),

                        Forms\Components\Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active candidates appear on voting page'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_filename')
                    ->label('Photo')
                    ->circular()
                    ->width(50)
                    ->height(50)
                    ->defaultImageUrl(function ($record) {
                        return 'https://ui-avatars.com/api/?background=8B0000&color=fff&size=50&name=' . urlencode($record->display_name);
                    }),

                Tables\Columns\TextColumn::make('display_name')
                    ->label('Candidate Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sector')
                    ->label('Sector')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('status')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('d M Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sector')
                    ->options(function () {
                        return Sector::whereNotNull('sector_code')
                            ->pluck('sector_name', 'sector_code')
                            ->toArray();
                    }),
                Tables\Filters\Filter::make('active')
                    ->label('Active Only')
                    ->query(fn ($query) => $query->where('status', 'active')),
                Tables\Filters\Filter::make('has_photo')
                    ->label('Has Photo')
                    ->query(fn ($query) => $query->whereNotNull('photo_filename')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('view_photo')
                    ->label('View Photo')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Candidate Photo')
                    ->modalContent(function ($record) {
                        $photoUrl = $record->photo_url ?? asset('storage/' . $record->photo_filename);
                        return view('filament.modals.view-photo', ['photoUrl' => $photoUrl, 'candidate' => $record]);
                    })
                    ->visible(fn ($record) => $record->photo_filename || $record->photo_path),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('sector');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCandidates::route('/'),
            'create' => Pages\CreateCandidate::route('/create'),
            'edit' => Pages\EditCandidate::route('/{record}/edit'),
        ];
    }
}
