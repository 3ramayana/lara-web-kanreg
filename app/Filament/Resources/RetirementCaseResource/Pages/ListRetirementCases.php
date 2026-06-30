<?php

namespace App\Filament\Resources\RetirementCaseResource\Pages;

use App\Filament\Resources\RetirementCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRetirementCases extends ListRecords
{
    protected static string $resource = RetirementCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
