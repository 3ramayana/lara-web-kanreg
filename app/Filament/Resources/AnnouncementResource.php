<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Announcement;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';

    protected static ?string $navigationGroup = 'Manajemen Postingan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make([
                Forms\Components\TextInput::make('title')->required()->label('Judul Pengumuman')->maxLength(255),
                Forms\Components\RichEditor::make('content')->required()->label('deskripsi'),
                Forms\Components\FileUpload::make('file')
                    ->label('Masukkan Foto')
                    ->directory('announcements')
                    ->disk('public_uploads')
                    ->maxSize(2048)
                    ->image()
                    ->helperText('Hanya file gambar (JPG, PNG). Maksimal ukuran 2 MB.')
                    ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png'])
                    ->rules(['mimes:pdf,jpg,png']),
                Forms\Components\TextInput::make('link')->label('Masukkan Link Jika Ada')->url(),
                Forms\Components\Toggle::make('is_active')->label('Status')->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(10),
                // ->description(fn (Announcement $record): string => $record->content)
                // ->html(),
                Tables\Columns\TextColumn::make('content')->html()->limit(10)->searchable(),
                Tables\Columns\ImageColumn::make('file')->disk('public_uploads')->searchable(),
                Tables\Columns\TextColumn::make('link')->searchable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
