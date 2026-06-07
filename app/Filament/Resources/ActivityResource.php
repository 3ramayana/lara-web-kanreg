<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use Spatie\Activitylog\Models\Activity;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Sistem';
    protected static ?string $navigationLabel = 'Log Aktivitas (Audit Trail)';
    protected static ?string $pluralModelLabel = 'Log Aktivitas';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Aktivitas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Tipe Data')
                    ->searchable(),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Oleh (User)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
}
