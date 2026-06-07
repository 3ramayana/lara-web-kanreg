<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Service;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use Filament\Resources\Resource;
use Forms\Components\FileUpload;
use Forms\Components\RichEditor;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ServiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ServiceResource\RelationManagers;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Postingan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Informasi Layanan')
                        ->description('Penjelasan rinci mengenai status progres layanan.')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Judul / Nama Progres')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('description')
                                ->label('Keterangan Progres')
                                ->columnSpanFull(),
                        ]),
                ])->columnSpan(['sm' => 3, 'lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Detail Kategori')
                        ->icon('heroicon-o-tag')
                        ->schema([
                            Forms\Components\Select::make('category')
                                ->label('Jenis Layanan')
                                ->options([
                                    'cat' => 'Penggunaan CAT',
                                    'cltn' => 'Cuti diluar Tanggungan Negara',
                                    'kp' => 'Kenaikan Pangkat',
                                    'mt' => 'Manajemen Talenta',
                                    'mutasi' => 'Mutasi',
                                    'nip' => 'Penetapan NIP & PPK',
                                    'pensiun' => 'Pensiun',
                                    'pengangkatan' => 'Pengangkatan C1',
                                    'pg' => 'Penyesuaian Gelar',
                                    'peremajaan' => 'Peremajaan',
                                    'pmk' => 'PMK',
                                    'statistik' => 'Statistik ASN',
                                    'janda_duda' => 'Pensiun Janda/Duda',
                                    'pembinaan' => 'Pembinaan',
                                    'pengaktifan' => 'Pengaktifan PNS',
                                ])
                                ->native(false)
                                ->searchable()
                                ->required(),
                            Forms\Components\DatePicker::make('periode')
                                ->label('Periode Pelaksanaan')
                                ->required()
                                ->placeholder('Pilih Tanggal')
                                ->format('d/m/Y')
                                ->native(false),
                            Forms\Components\TextInput::make('link')
                                ->label('Tautan External')
                                ->placeholder('https://...')
                                ->url(),
                        ]),

                    Forms\Components\Section::make('Lampiran File')
                        ->icon('heroicon-o-paper-clip')
                        ->schema([
                            Forms\Components\FileUpload::make('thumbnail')
                                ->label('Thumbnail Progres')
                                ->directory('service_thumbnails')
                                ->disk('public_uploads')
                                ->maxSize(2048)
                                ->image()
                                ->imageEditor()
                                ->helperText('Format JPG/PNG. Maks 2 MB.')
                                ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png']),
                            Forms\Components\FileUpload::make('document')
                                ->label('Dokumen Progres (PDF)')
                                ->directory('service_documents')
                                ->disk('public_uploads')
                                ->maxSize(10000)
                                ->helperText('Hanya file dokumen PDF. Maks 10 MB.')
                                ->acceptedFileTypes(['application/pdf'])
                                ->rules(['mimes:pdf']),
                        ]),
                ])->columnSpan(['sm' => 3, 'lg' => 1]),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->words(5), 
            Tables\Columns\TextColumn::make('category'), 
            Tables\Columns\ImageColumn::make('thumbnail')
            ->square()
            ->searchable()
            ->disk('public_uploads'), 
            Tables\Columns\TextColumn::make('link')
            ->toggleable(isToggledHiddenByDefault: true)
            ->badge()
            ->searchable()
            ->words(3), 
            Tables\Columns\TextColumn::make('document')
            ->badge()
            ->searchable(), 
            Tables\Columns\TextColumn::make('periode')->searchable(), 
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true), 
            Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)])
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
