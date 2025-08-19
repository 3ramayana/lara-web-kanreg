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
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('category_id')
                    ->relationship(name: 'categories', titleAttribute: 'name'),
                    TextInput::make('title')
                    ->live(onBlur:true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required()
                    ->autocapitalize('words'),
                    TextInput::make('slug')
                    ->required()
                    ->readOnly(),
                    // SpatieMediaLibraryFileUpload::make('thumbnail'),
										FileUpload::make('thumbnail')
										->required()
										->label('Thumbnail Postingan')
										->directory('post-thumbnail')
										->disk('public_uploads')
										->maxSize(2048)
										->image()
										->helperText('Hanya file gambar (JPG, PNG). Maksimal ukuran 2 MB.')
										->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png']),
                    RichEditor::make('content')
										->required(),
                    // Toggle::make('status'),
										Select::make('status')
										->label('Status')
										->options([
												0 => 'Draft',
												1 => 'Published',
										])
										->default(0) // Default: Draft
										->required(),
                    Select::make('is_headline')
										->label('Postingan Headline')
										->options([
												0 => 'Bukan Headline',
												1 => 'Headline',
										])
										->default(0) // Default: Draft
										->required(),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title')
								->words(5),
                TextColumn::make('categories.name'),
                ImageColumn::make('thumbnail')
								->disk('public_uploads'),
								BadgeColumn::make('status')
								->label('Status')
                ->colors([
									'success' => fn ($state): bool => $state === 1, // Published
									'danger' => fn ($state): bool => $state === 0, // Draft
								])
								->formatStateUsing(fn ($state) => $state === 1 ? 'Published' : 'Draft'),
                
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
