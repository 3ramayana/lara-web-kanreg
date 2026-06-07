<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnresolvedSearchLogResource\Pages;
use App\Filament\Resources\UnresolvedSearchLogResource\RelationManagers;
use App\Models\UnresolvedSearchLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class UnresolvedSearchLogResource extends Resource
{
    protected static ?string $model = UnresolvedSearchLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';
    
    protected static ?string $navigationGroup = 'Layanan';
    
    protected static ?string $modelLabel = 'Riwayat Pencarian Gagal';

    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole(['admin', 'Admin Pensiun']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('query')
                    ->label('Kata Kunci (Query)')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('ip_address')
                    ->label('IP Address')
                    ->disabled(),
                Forms\Components\TextInput::make('user_agent')
                    ->label('User Agent')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('query')
                    ->label('Kata Kunci (Query)')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Pencarian')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
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
            'index' => Pages\ListUnresolvedSearchLogs::route('/'),
            'create' => Pages\CreateUnresolvedSearchLog::route('/create'),
            'edit' => Pages\EditUnresolvedSearchLog::route('/{record}/edit'),
        ];
    }
}
