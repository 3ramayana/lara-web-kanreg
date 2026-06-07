<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

		protected static ?string $navigationGroup = 'Manajemen User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Group::make()->schema([
                        Forms\Components\Section::make('Informasi Pribadi')
                            ->description('Data diri pengguna sistem.')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required(),
                                TextInput::make('nip')
                                    ->label('NIP')
                                    ->required()
                                    ->numeric()
                                    ->unique(ignoreRecord: true),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true),
                            ])->columns(2),

                        Forms\Components\Section::make('Keamanan & Password')
                            ->description('Setel kata sandi untuk pengguna ini.')
                            ->icon('heroicon-o-lock-closed')
                            ->schema([
                                TextInput::make('password')
                                    ->password()
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->dehydrated(fn (?string $state) => filled($state))
                                    ->confirmed()
                                    ->rules([
                                        'nullable',
                                        Password::min(8)
                                            ->letters()
                                            ->numbers()
                                            ->symbols()
                                            ->uncompromised(),
                                    ]),
                                TextInput::make('password_confirmation')
                                    ->password()
                                    ->requiredWith('password')
                                    ->dehydrated(false)
                                    ->same('password'),
                            ])->columns(2),
                    ])->columnSpan(['sm' => 3, 'lg' => 2]),

                    Forms\Components\Group::make()->schema([
                        Forms\Components\Section::make('Hak Akses & Unit Kerja')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Select::make('roles')
                                    ->label('Role (Peran)')
                                    ->required()
                                    ->relationship('roles', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->native(false),
                                Select::make('departement_id')
                                    ->relationship('departements', 'name')
                                    ->label('Unit Kerja')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                            ]),
                    ])->columnSpan(['sm' => 3, 'lg' => 1]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
								BadgeColumn::make('roles.name')
										->label('Role')
										->colors([
											'primary',
											'success' => 'Admin',
											'warning'	=> 'Penulis',
										]),
								TextColumn::make('departements.name')
										->label('Unit Kerja')
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
