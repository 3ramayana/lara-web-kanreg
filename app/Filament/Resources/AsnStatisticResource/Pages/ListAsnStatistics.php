<?php

namespace App\Filament\Resources\AsnStatisticResource\Pages;

use App\Filament\Resources\AsnStatisticResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsnStatistics extends ListRecords
{
    protected static string $resource = AsnStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\ImportAction::make()
                ->importer(\App\Filament\Imports\AsnStatisticImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
