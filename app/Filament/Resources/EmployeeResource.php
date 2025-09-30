<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Module Arsip Digital';
    protected static ?string $pluralModelLabel = 'Pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                        ->label('Nama Pegawai'),
                    Forms\Components\TextInput::make('nip')
                            ->required()
                            ->maxLength(255)
                            ->label('NIP'),
                    Forms\Components\Select::make('departement_id')
                            ->relationship('departement', 'name')
                            ->required()
                            ->label('Unit Kerja'),
                    Forms\Components\TextInput::make('position')
                        ->required()
                        ->maxLength(255)
                        ->label('Jabatan'),
                    Forms\Components\Select::make('category')
                            ->options([
                                'kepala_bkn' => 'Kepala BKN',
                                'jptm' => 'JPT Madya',
                                'kepala_regional' => 'Kepala Kantor Regional XIV BKN',
                                'administrator' => 'Pejabat Administrator',
                                'pengawas' => 'Pejabat Pengawas',
                                'fungsional' => 'fungsional'
                            ])
                            ->required()
                            ->label('Kategori'),
                    Forms\Components\FileUpload::make('photo')
                        ->label('Masukkan Foto')
                        ->directory('employee')
                        ->disk('public_uploads')
                        ->maxSize(2048)
                        ->image()
                        ->helperText('Hanya file gambar (JPG, PNG). Maksimal ukuran 2 MB.')
                        ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png'])
                        ->rules(['mimes:pdf,jpg,png']),
                    Forms\Components\FileUpload::make('lhkpn')
                        ->label('Masukkan Dokumen LHKPN')
                        ->directory('lhkpn')
                        ->disk('public_uploads')
                        ->maxSize(6000)
                        ->helperText('Hanya file dokumen (PDF). Maksimal ukuran 2 MB.')
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->rules(['mimes:pdf']),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('departement_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('photo')
					->disk('public_uploads')
                    ->searchable(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
