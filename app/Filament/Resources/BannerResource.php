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
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Group::make()->schema([
                        Forms\Components\Section::make('Informasi Banner')
                            ->description('Keterangan dan penempatan banner.')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Judul Banner')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('desc')
                                    ->required()
                                    ->label('Keterangan Singkat')
                                    ->maxLength(255),
                            ]),
                    ])->columnSpan(['sm' => 3, 'lg' => 2]),

                    Forms\Components\Group::make()->schema([
                        Forms\Components\Section::make('Pengaturan & File')
                            ->icon('heroicon-o-cog')
                            ->schema([
                                Forms\Components\Select::make('category')
                                    ->options([
                                        'banner' => 'Banner Utama',
                                        'struktur_kanreg' => 'Struktur Kantor Regional',
                                        'struktur_pimpinan' => 'Struktur Pimpinan',
                                        'agenda' => 'Agenda Kantor Regional',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->label('Kategori Penempatan'),
                                Forms\Components\Radio::make('is_active')
                                    ->options([
                                        1 => 'Aktif (Published)',
                                        0 => 'Tidak Aktif (Draft)'
                                    ])
                                    ->default(1)
                                    ->label('Status Tayang'),
                                Forms\Components\FileUpload::make('file')
                                    ->required()
                                    ->label('Gambar Banner')
                                    ->directory('banners')
                                    ->disk('public_uploads')
                                    ->maxSize(2048)
                                    ->image()
                                    ->imageEditor()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('1920')
                                    ->optimize('webp')
                                    ->helperText('Gambar akan dikompres & dikonversi otomatis ke WebP. Maks 2MB.')
                                    ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/webp']),
                            ]),
                    ])->columnSpan(['sm' => 3, 'lg' => 1]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
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
