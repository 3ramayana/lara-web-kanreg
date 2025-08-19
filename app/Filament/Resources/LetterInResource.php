<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use App\Models\LetterIn;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LetterInResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LetterInResource\RelationManagers;

class LetterInResource extends Resource
{
    protected static ?string $model = LetterIn::class;

    protected static ?string $pluralModelLabel = 'Surat Masuk';
    protected static ?string $navigationGroup = 'Module Arsip Digital';
    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_letter_id')
										->relationship('category_letter', 'name')
                    ->required()
                    ->label('Kategori Surat'),
                Forms\Components\Select::make('departement_id')
										->relationship('departement','name')
                    ->required()
										->reactive()
										->afterStateUpdated(fn($state, callable $set)=>$set('employee_id', null))
                    ->label('Disposisi Surat - Unit'),
								Forms\Components\Select::make('employee_id')
										->relationship('employee','name')
                    ->required()
										->options(function(callable $get){
											$departementId = $get('departement_id');
											if(!$departementId){
												return[];
											}

											return Employee::where('departement_id', $departementId)
											->pluck('name', 'id')->toArray();
										})
                    ->label('Disposisi Surat - Pegawai'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(50)
										->label('Judul Surat'),
                Forms\Components\TextInput::make('reference_number')
                    ->required()
                    ->unique()
										->label('Nomor Surat'),
                Forms\Components\DatePicker::make('date_letter')
                    ->required()
										->label('Tanggal Surat'),
                Forms\Components\DatePicker::make('date_in')
                    ->required()
										->label('Tanggal Masuk Instansi'),
                Forms\Components\TextInput::make('origin_letter')
                    ->required()
                    ->maxLength(30)
										->label('Asal Surat'),
                Forms\Components\Select::make('properties_letter')
                    ->required()
                    ->options([
											'Biasa' => 'biasa',
											'Rahasia' =>	'rahasia',
											'Penting'	=>	'penting'
										])
										->label('Sifat Surat'),
                Forms\Components\FileUpload::make('file')
                    ->required()
										->directory('uploads')
										->disk('public_uploads')
                    ->label('Upload Surat')
										->maxSize(10240)
										->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']),
            ]);
    }

		public static function getEloquentQuery(): Builder
		{
				$user = Auth::user();
				if($user->hasRole('admin')){
					return parent::getEloquentQuery();
				}
				return parent::getEloquentQuery()->where('departement_id', $user->departement_id);
		}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category_letter.name')
                    // ->numeric()
                    ->sortable()
										->label('Kategori Surat'),
                Tables\Columns\TextColumn::make('departement.name')
                    // ->numeric()
                    ->sortable()
										->label('Disposisi Bidang'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
										->label('Judul Surat'),
                Tables\Columns\TextColumn::make('reference_number')
                    ->numeric()
                    ->sortable()
										->label('Nomor Surat'),
                Tables\Columns\TextColumn::make('date_in')
                    // ->date()
										->formatStateUsing(fn ($state) => Carbon::parse($state)->translatedFormat('d F Y'))
                    ->sortable()
										->label('Surat Masuk'),
                Tables\Columns\TextColumn::make('origin_letter')
                    ->searchable()
										->label('Asal Surat'),
                // Tables\Columns\TextColumn::make('properties_letter')
                //     ->searchable()
								// 		->label('SIfat Surat'),
                // Tables\Columns\TextColumn::make('file')
										// ->disk('public_uploads')
										// ->formatStateUsing(fn($state)=>$state ? basename($state) :'Tidak ada Data')
										// ->url(fn($record)=>Storage::disk('public_uploads')->url($record->file)),
            ])
            ->filters([
								SelectFilter::make('departement')
										->label('Unit Kerja')
										->relationship('departement','name')
										->hidden(fn () => !auth()->user()->hasRole('admin')),
								SelectFilter::make('category_letter')
										->label('Kategori Surat')
										->relationship('category_letter','name')
										->hidden(fn () => !auth()->user()->hasRole('admin')),
										Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Tanggal Awal'),
                        DatePicker::make('created_until')
                            ->label('Tanggal Akhir'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
								// SelectFilter::make('month')
								// 		->label('Bulan')
								// 		->options([
								// 			'1' => 'Januari',
								// 			'2' => 'Februari',
								// 			'3' => 'Maret',
								// 			'4' => 'April',
								// 			'5' => 'Mei',
								// 			'6' => 'Juni',
								// 			'7' => 'Juli',
								// 			'8' => 'Agustus',
								// 			'9' => 'September',
								// 			'10' => 'Oktober',
								// 			'11' => 'November',
								// 			'12' => 'Desember',
								// 	])
								// 	->query(fn ($query, $value) => $query->whereMonth('date', $value)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
										->label('unduh')
										->icon('heroicon-o-arrow-down-on-square')
										->url(fn ($record) => Storage::disk('public_uploads')->url($record->file))
										->openUrlInNewTab(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
							])
						->defaultGroup('properties_letter');
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
            'index' => Pages\ListLetterIns::route('/'),
            'create' => Pages\CreateLetterIn::route('/create'),
            'edit' => Pages\EditLetterIn::route('/{record}/edit'),
        ];
    }

		public static function getWidgets(): array
    {
        return [
            LetterInResource\Widgets\TotalSurat::class,
        ];
    }
}
