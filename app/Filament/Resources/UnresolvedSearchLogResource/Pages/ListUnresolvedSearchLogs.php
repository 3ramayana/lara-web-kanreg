<?php

namespace App\Filament\Resources\UnresolvedSearchLogResource\Pages;

use App\Filament\Resources\UnresolvedSearchLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnresolvedSearchLogs extends ListRecords
{
    protected static string $resource = UnresolvedSearchLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
