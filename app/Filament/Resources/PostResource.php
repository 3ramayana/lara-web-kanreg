<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Manajemen Postingan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)->schema([
                // Kolom Utama (Kiri)
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Konten Berita')
                        ->description('Masukkan judul dan isi teks berita secara lengkap.')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Judul Berita')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                ->required()
                                ->autocapitalize('words')
                                ->maxLength(255),
                                
                            Forms\Components\TextInput::make('slug')
                                ->label('URL Slug')
                                ->required()
                                ->readOnly()
                                ->helperText('URL berita akan ter-generate otomatis.'),
                                
                            Forms\Components\RichEditor::make('content')
                                ->label('Isi Konten')
                                ->required()
                                ->columnSpanFull(),
                        ])->columns(2),
                ])->columnSpan(['sm' => 3, 'md' => 3, 'lg' => 2]),

                // Kolom Pengaturan (Kanan)
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Pengaturan')
                        ->description('Tentukan kategori dan status publikasi.')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            Forms\Components\Select::make('category_id')
                                ->label('Kategori Berita')
                                ->relationship(name: 'categories', titleAttribute: 'name')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->native(false),

                            Forms\Components\Select::make('status')
                                ->label('Status Publikasi')
                                ->options([
                                    0 => 'Draft',
                                    1 => 'Published',
                                ])
                                ->default(0)
                                ->required()
                                ->native(false),

                            Forms\Components\Select::make('is_headline')
                                ->label('Tipe Sorotan')
                                ->options([
                                    0 => 'Biasa (Standar)',
                                    1 => 'Jadikan Headline',
                                ])
                                ->default(0)
                                ->required()
                                ->native(false),
                        ]),

                    Forms\Components\Section::make('Media Visual')
                        ->description('Unggah gambar sampul.')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\FileUpload::make('thumbnail')
                                ->required()
                                ->label('Thumbnail Postingan')
                                ->directory('post-thumbnail')
                                ->disk('public_uploads')
                                ->maxSize(2048)
                                ->image()
                                // ->imageEditor() // Mengaktifkan fitur crop/edit gambar bawaan Filament
                                // ->imageResizeMode('cover')
                                // ->imageResizeTargetWidth('1280')
                                ->helperText('Gambar akan dikompres & dikonversi otomatis ke WebP. Maks 2MB.')
                                ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/webp']),
                        ]),
                ])->columnSpan(['sm' => 3, 'md' => 3, 'lg' => 1]),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title')->words(5),
                TextColumn::make('categories.name'),
                ImageColumn::make('thumbnail')->disk('public_uploads'),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => fn($state): bool => $state === 1, // Published
                        'danger' => fn($state): bool => $state === 0, // Draft
                    ])
                    ->formatStateUsing(fn($state) => $state === 1 ? 'Published' : 'Draft'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
