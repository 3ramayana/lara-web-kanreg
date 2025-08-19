<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Banner;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BannerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BannerResource\RelationManagers;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Manajemen Postingan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
									Forms\Components\TextInput::make('name')
                    ->required()
										->label('Judul')
                    ->maxLength(255),
                Forms\Components\TextInput::make('desc')
                    ->required()
										->label('Ket')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('file')
                    ->required()
										->directory('banners')
										->disk('public_uploads')
										->maxSize(2048)
										->image()
										->helperText('Hanya file gambar (JPG, PNG). Maksimal ukuran 2 MB.')
										->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png']),
										Radio::make('status')
										->options([
												'true' => 'Aktif',
												'false' => 'Tidak Aktif'
										])
								])
										
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('desc')
                    ->searchable(),
										ImageColumn::make('file')
										->disk('public_uploads'),
										BadgeColumn::make('is_active')
										->label('Status')
										->colors([
											'success' => fn ($state): bool => $state === 1, // Published
											'danger' => fn ($state): bool => $state === 0, // Draft
										])
										->formatStateUsing(fn ($state) => $state === 1 ? 'Published' : 'Draft'),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
