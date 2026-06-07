<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RetirementCaseResource\Pages;
use App\Filament\Resources\RetirementCaseResource\RelationManagers;
use App\Models\RetirementCase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RetirementCaseResource extends Resource
{
    protected static ?string $model = RetirementCase::class;

    protected static ?string $navigationGroup = 'Layanan';
    protected static ?string $modelLabel = 'Kasus Pensiun';
    protected static ?string $pluralModelLabel = 'Kasus Pensiun';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole(['admin', 'Admin Pensiun']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul Kasus / Permasalahan')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('problem')
                    ->label('Deskripsi Permasalahan')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('resolution')
                    ->label('Langkah Penyelesaian')
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('tags')
                    ->label('Tag / Kata Kunci')
                    ->placeholder('Ketik tag lalu tekan enter (Contoh: BUP, Janda/Duda)')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_published')
                    ->label('Tampilkan / Publikasi')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Kasus')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('tags')
                    ->label('Tag')
                    ->badge()
                    ->separator(',')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publikasi')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListRetirementCases::route('/'),
            'create' => Pages\CreateRetirementCase::route('/create'),
            'edit' => Pages\EditRetirementCase::route('/{record}/edit'),
        ];
    }
}
