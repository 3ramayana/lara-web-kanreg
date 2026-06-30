<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RoleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoleResource\RelationManagers;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-end-on-rectangle';
    protected static ?string $navigationGroup = 'Manajemen User';

    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Role')
                    ->description('Tentukan nama peran yang akan diberikan kepada pengguna.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Role')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),

                Forms\Components\Section::make('Hak Akses (Permissions)')
                    ->description('Pilih hak akses (permission) apa saja yang dimiliki oleh role ini.')
                    ->schema([
                        Forms\Components\CheckboxList::make('permissions')
                            ->label('')
                            ->relationship('permissions', 'name')
                            ->searchable()
                            ->bulkToggleable()
                            ->columns([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                            ])
                            ->gridDirection('row'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
							Tables\Columns\TextColumn::make('name')
							->label('Nama Peran')
							->sortable()
							->searchable(),

							Tables\Columns\BadgeColumn::make('permissions.name')
							->label('Izin')
							->separator(', '),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
