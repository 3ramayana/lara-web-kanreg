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
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Informasi Pengumuman')
                        ->description('Judul dan rincian pengumuman.')
                        ->icon('heroicon-o-speaker-wave')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->label('Judul Pengumuman')
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('content')
                                ->required()
                                ->label('Deskripsi Lengkap'),
                        ]),
                ])->columnSpan(['sm' => 3, 'lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Pengaturan & Lampiran')
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Tampilkan Pengumuman')
                                ->default(true)
                                ->required(),
                            Forms\Components\TextInput::make('link')
                                ->label('Tautan / URL Tambahan')
                                ->placeholder('https://...')
                                ->url(),
                            Forms\Components\FileUpload::make('file')
                                ->label('Lampiran Dokumen/Gambar')
                                ->directory('announcements')
                                ->disk('public_uploads')
                                ->maxSize(2048)
                                ->image()
                                ->imageEditor()
                                ->imageResizeMode('cover')
                                ->imageResizeTargetWidth('1280')
                                ->optimize('webp')
                                ->helperText('File gambar (JPG, PNG, WEBP) atau PDF. Gambar akan dikompres otomatis. Maks 2MB.')
                                ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/webp'])
                                ->rules(['mimes:pdf,jpg,png,webp']),
                        ]),
                ])->columnSpan(['sm' => 3, 'lg' => 1]),
            ])
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
