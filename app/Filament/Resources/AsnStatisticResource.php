<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsnStatisticResource\Pages;
use App\Filament\Resources\AsnStatisticResource\RelationManagers;
use App\Models\AsnStatistic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsnStatisticResource extends Resource
{
    protected static ?string $model = AsnStatistic::class;

    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $modelLabel = 'Statistik ASN';
    protected static ?string $pluralModelLabel = 'Statistik ASN';
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Laporan')
                    ->description('Tentukan masa pelaporan, wilayah, dan jenis kepegawaian.')
                    ->schema([
                        Forms\Components\TextInput::make('year')
                            ->label('Tahun Laporan')
                            ->required()
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(2100)
                            ->default(date('Y')),
                        Forms\Components\Select::make('month')
                            ->label('Bulan Laporan')
                            ->options([
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ])
                            ->required()
                            ->default(date('n')),
                        Forms\Components\Select::make('city_id')
                            ->label('Kabupaten / Kota / Provinsi')
                            ->relationship('city', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('employee_type')
                            ->label('Jenis Pegawai')
                            ->options([
                                'PNS' => 'PNS',
                                'PPPK' => 'PPPK',
                            ])
                            ->live()
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Demografi Kelamin')
                    ->description('Jumlah ASN berdasarkan jenis kelamin.')
                    ->schema([
                        Forms\Components\TextInput::make('gender_male')
                            ->label('Laki-Laki')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\TextInput::make('gender_female')
                            ->label('Perempuan')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Rentang Usia')
                    ->description('Jumlah ASN berdasarkan rentang usia saat ini.')
                    ->schema([
                        Forms\Components\TextInput::make('age_17_20')->label('17 - 20 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('age_21_30')->label('21 - 30 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('age_31_40')->label('31 - 40 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('age_41_50')->label('41 - 50 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('age_51_58')->label('51 - 58 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('age_58_plus')->label('> 58 Tahun')->numeric()->default(0)->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Tingkat Pendidikan')
                    ->description('Jumlah ASN berdasarkan kualifikasi pendidikan terakhir.')
                    ->schema([
                        Forms\Components\TextInput::make('edu_sd')->label('SD Sederajat')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_smp')->label('SMP Sederajat')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_sma')->label('SMA Sederajat')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_d1')->label('Diploma I')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_d2')->label('Diploma II')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_d3')->label('Diploma III')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_d4')->label('Diploma IV')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_s1')->label('Strata 1 (S1)')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_s2')->label('Strata 2 (S2)')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_s3')->label('Strata 3 (S3)')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('edu_profesi')->label('Profesi')->numeric()->default(0)->required(),
                    ])->columns(4),

                Forms\Components\Section::make('Rentang Masa Kerja')
                    ->description('Jumlah ASN berdasarkan masa kerja keseluruhan.')
                    ->schema([
                        Forms\Components\TextInput::make('mk_0_5')->label('0 - 5 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('mk_6_10')->label('6 - 10 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('mk_11_15')->label('11 - 15 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('mk_16_20')->label('16 - 20 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('mk_21_25')->label('21 - 25 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('mk_26_30')->label('26 - 30 Tahun')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('mk_30_plus')->label('> 30 Tahun')->numeric()->default(0)->required(),
                    ])->columns(4),

                Forms\Components\Section::make('Kelompok Jabatan')
                    ->description('Jumlah ASN berdasarkan tingkat jabatan.')
                    ->schema([
                        Forms\Components\TextInput::make('pos_jpt_madya')->label('JPT Madya')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('pos_jpt_pratama')->label('JPT Pratama')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('pos_administrator')->label('Administrator')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('pos_pengawas')->label('Pengawas')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('pos_fungsional')->label('Fungsional')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('pos_pelaksana')->label('Pelaksana')->numeric()->default(0)->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Golongan PNS')
                    ->description('Jumlah PNS berdasarkan Golongan / Ruang Kepangkatan.')
                    ->visible(fn (Forms\Get $get) => $get('employee_type') === 'PNS')
                    ->schema([
                        Forms\Components\TextInput::make('gol_pns_1')->label('Golongan I')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pns_2')->label('Golongan II')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pns_3')->label('Golongan III')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pns_4')->label('Golongan IV')->numeric()->default(0)->required(),
                    ])->columns(4),

                Forms\Components\Section::make('Golongan PPPK')
                    ->description('Jumlah PPPK berdasarkan Golongan (I - XI).')
                    ->visible(fn (Forms\Get $get) => $get('employee_type') === 'PPPK')
                    ->schema([
                        Forms\Components\TextInput::make('gol_pppk_1')->label('Golongan I')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_2')->label('Golongan II')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_3')->label('Golongan III')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_4')->label('Golongan IV')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_5')->label('Golongan V')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_6')->label('Golongan VI')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_7')->label('Golongan VII')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_8')->label('Golongan VIII')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_9')->label('Golongan IX')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_10')->label('Golongan X')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('gol_pppk_11')->label('Golongan XI')->numeric()->default(0)->required(),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('month')
                    ->label('Bulan')
                    ->formatStateUsing(fn (string $state): string => [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ][$state] ?? $state)
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('Wilayah')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('employee_type')
                    ->label('Jenis Pegawai')
                    ->colors([
                        'primary' => 'PNS',
                        'success' => 'PPPK',
                    ]),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total Pegawai')
                    ->getStateUsing(function (AsnStatistic $record) {
                        return $record->total;
                    }),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('year')
                    ->label('Tahun')
                    ->options(function () {
                        return AsnStatistic::query()->distinct()->pluck('year', 'year')->toArray();
                    }),
                Tables\Filters\SelectFilter::make('month')
                    ->label('Bulan')
                    ->options([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ]),
                Tables\Filters\SelectFilter::make('city_id')
                    ->label('Wilayah')
                    ->relationship('city', 'name'),
                Tables\Filters\SelectFilter::make('employee_type')
                    ->label('Jenis')
                    ->options([
                        'PNS' => 'PNS',
                        'PPPK' => 'PPPK',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAsnStatistics::route('/'),
            'create' => Pages\CreateAsnStatistic::route('/create'),
            'edit' => Pages\EditAsnStatistic::route('/{record}/edit'),
        ];
    }
}
