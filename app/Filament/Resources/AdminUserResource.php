<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminUserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class AdminUserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Admin Management';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Admin Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('Leave blank to keep current password (edit mode)')
                            ->minLength(6),
                        
                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Regular Admin',
                                'super_admin' => 'Super Admin',
                            ])
                            ->default('admin')
                            ->required()
                            ->helperText('Super Admin can manage other admins and delete records'),
                        
                        Forms\Components\Toggle::make('can_delete')
                            ->label('Can Delete Records')
                            ->default(false)
                            ->helperText('Allow this admin to delete voters and candidates'),
                        
                        Forms\Components\Toggle::make('can_manage_admins')
                            ->label('Can Manage Other Admins')
                            ->default(false)
                            ->helperText('Allow this admin to create/edit other admin accounts'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('role')
                    ->label('Role')
                    ->colors([
                        'success' => 'super_admin',
                        'primary' => 'admin',
                    ])
                    ->formatStateUsing(fn ($state) => $state === 'super_admin' ? 'Super Admin' : 'Admin'),
                    
                Tables\Columns\IconColumn::make('can_delete')
                    ->label('Can Delete')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('can_manage_admins')
                    ->label('Manage Admins')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Regular Admin',
                        'super_admin' => 'Super Admin',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()->canDelete()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()->canDelete()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminUsers::route('/'),
            'create' => Pages\CreateAdminUser::route('/create'),
            'edit' => Pages\EditAdminUser::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->canManageAdmins();
    }

    public static function canCreate(): bool
    {
        return auth()->user()->canManageAdmins();
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->canManageAdmins();
    }
}