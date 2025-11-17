<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectorResource\Pages;
use App\Models\Sector;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class SectorResource extends Resource
{
    protected static ?string $model = Sector::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Sectors';
    protected static ?string $navigationGroup = 'Voting Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('sector_name')
                ->label('Sector Name')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('sector_code')
                ->label('Code')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\Textarea::make('description')
                ->rows(3)
                ->label('Description'),

            Forms\Components\TextInput::make('max_candidates')
                ->numeric()
                ->default(1)
                ->label('Maximum Candidates Allowed'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sector_name')->sortable()->searchable(),
                TextColumn::make('sector_code')->sortable()->searchable(),
                TextColumn::make('max_candidates')->sortable(),
                TextColumn::make('description')->limit(40),
            ])
            ->filters([])
            ->actions([
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
            'index'  => Pages\ListSectors::route('/'),
            'create' => Pages\CreateSector::route('/create'),
            'edit'   => Pages\EditSector::route('/{record}/edit'),
        ];
    }
}
