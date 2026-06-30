<?php

namespace App\Filament\Imports;

use App\Models\AsnStatistic;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class AsnStatisticImporter extends Importer
{
    protected static ?string $model = AsnStatistic::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('city')
                ->relationship(resolveUsing: 'name')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('year')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('month')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer', 'min:1', 'max:12']),
            ImportColumn::make('employee_type')
                ->requiredMapping()
                ->rules(['required', 'in:PNS,PPPK']),
            ImportColumn::make('gender_male')->numeric()->rules(['required', 'integer']),
            ImportColumn::make('gender_female')->numeric()->rules(['required', 'integer']),
            
            ImportColumn::make('edu_sd')->numeric()->rules(['integer']),
            ImportColumn::make('edu_smp')->numeric()->rules(['integer']),
            ImportColumn::make('edu_sma')->numeric()->rules(['integer']),
            ImportColumn::make('edu_d3')->numeric()->rules(['integer']),
            ImportColumn::make('edu_d4')->numeric()->rules(['integer']),
            ImportColumn::make('edu_s1')->numeric()->rules(['integer']),
            ImportColumn::make('edu_s2')->numeric()->rules(['integer']),
            ImportColumn::make('edu_s3')->numeric()->rules(['integer']),

            ImportColumn::make('pos_struktural')->numeric()->rules(['integer']),
            ImportColumn::make('pos_fungsional')->numeric()->rules(['integer']),
            ImportColumn::make('pos_pelaksana')->numeric()->rules(['integer']),

            ImportColumn::make('age_20_30')->numeric()->rules(['integer']),
            ImportColumn::make('age_31_40')->numeric()->rules(['integer']),
            ImportColumn::make('age_41_50')->numeric()->rules(['integer']),
            ImportColumn::make('age_51_60')->numeric()->rules(['integer']),

            ImportColumn::make('gol_1')->numeric()->rules(['integer']),
            ImportColumn::make('gol_2')->numeric()->rules(['integer']),
            ImportColumn::make('gol_3')->numeric()->rules(['integer']),
            ImportColumn::make('gol_4')->numeric()->rules(['integer']),
            ImportColumn::make('gol_5')->numeric()->rules(['integer']),
            ImportColumn::make('gol_6')->numeric()->rules(['integer']),
            ImportColumn::make('gol_7')->numeric()->rules(['integer']),
            ImportColumn::make('gol_8')->numeric()->rules(['integer']),
            ImportColumn::make('gol_9')->numeric()->rules(['integer']),
            ImportColumn::make('gol_10')->numeric()->rules(['integer']),
            ImportColumn::make('gol_11')->numeric()->rules(['integer']),
            ImportColumn::make('gol_12')->numeric()->rules(['integer']),
            ImportColumn::make('gol_13')->numeric()->rules(['integer']),
            ImportColumn::make('gol_14')->numeric()->rules(['integer']),
            ImportColumn::make('gol_15')->numeric()->rules(['integer']),
            ImportColumn::make('gol_16')->numeric()->rules(['integer']),
            ImportColumn::make('gol_17')->numeric()->rules(['integer']),

            ImportColumn::make('work_1_5')->numeric()->rules(['integer']),
            ImportColumn::make('work_6_10')->numeric()->rules(['integer']),
            ImportColumn::make('work_11_20')->numeric()->rules(['integer']),
            ImportColumn::make('work_21_plus')->numeric()->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?AsnStatistic
    {
        // return AsnStatistic::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new AsnStatistic();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your asn statistic import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
