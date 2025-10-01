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
            Card::make([
                Forms\Components\TextInput::make('title')->label('Judul')->required()->maxLength(255),
                Forms\Components\RichEditor::make('description')->columnSpanFull(),
                Forms\Components\Select::make('category')
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
                    ->required(),
                Forms\Components\DatePicker::make('periode')->label('Periode')->required()->placeholder('Pilih Periode')->format('d/m/Y')->native(false),
                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Masukkan Foto Progress')
                    ->directory('service_thumbnails')
                    ->disk('public_uploads')
                    ->maxSize(2048)
                    ->image()
                    ->helperText('Hanya file gambar (JPG, PNG). Maksimal ukuran 2 MB.')
                    ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png'])
                    ->rules(['mimes:pdf,jpg,png']),
                Forms\Components\TextInput::make('link')->label('Masukkan Link Jika Ada')->url(),
                Forms\Components\FileUpload::make('document')
                    ->label('Masukkan Dokumen Progress')
                    ->directory('service_documents')
                    ->disk('public_uploads')
                    ->maxSize(10000)
                    ->helperText('Hanya file dokumen (PDF). Maksimal ukuran 10 MB.')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->rules(['mimes:pdf']),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->words(5), 
            Tables\Columns\ImageColumn::make('thumbnail')->searchable(), 
            Tables\Columns\TextColumn::make('link')->searchable()->words(5), 
            Tables\Columns\TextColumn::make('document')->searchable(), 
            Tables\Columns\TextColumn::make('category'), 
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
