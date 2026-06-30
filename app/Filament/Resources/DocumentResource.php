<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Document;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DocumentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DocumentResource\RelationManagers;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Postingan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Group::make()->schema([
                        Forms\Components\Section::make('Detail Dokumen')
                            ->description('Informasi utama tentang dokumen yang akan diunggah.')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Dokumen')
                                    ->autocomplete(false)
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('desc')
                                    ->label('Deskripsi Lengkap (Opsional)'),
                            ]),
                    ])->columnSpan(['sm' => 3, 'lg' => 2]),

                    Forms\Components\Group::make()->schema([
                        Forms\Components\Section::make('Klasifikasi & File')
                            ->icon('heroicon-o-archive-box')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->required()
                                    ->relationship('categories', 'name')
                                    ->native(false)
                                    ->searchable()
                                    ->preload()
                                    ->label('Kategori Dokumen'),
                                Forms\Components\TextInput::make('year')
                                    ->required()
                                    ->label('Tahun Terbit')
                                    ->numeric()
                                    ->maxLength(4),
                                Select::make('is_public')
                                    ->label('Aksesibilitas')
                                    ->options([
                                        0 => 'Private (Hanya Internal)',
                                        1 => 'Public (Bisa Diunduh Umum)',
                                    ])
                                    ->default(0)
                                    ->native(false)
                                    ->required(),
                                Forms\Components\FileUpload::make('file')
                                    ->required()
                                    ->label('Unggah Berkas')
                                    ->directory('documents')
                                    ->disk('public_uploads')
                                    ->maxSize(2048)
                                    ->helperText('Format PDF/Word. Maks 2MB.')
                                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']),
                            ]),
                    ])->columnSpan(['sm' => 3, 'lg' => 1]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Dokumen')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('desc')
                    ->label('Deskripsi')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => strip_tags($state))
                    ->limit(50)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Akses Publik')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-lock-closed'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diunggah Pada')
                    ->dateTime('d M Y')
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
