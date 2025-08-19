<?php

namespace App\Filament\Resources\CategoryLetterResource\Pages;

use App\Filament\Resources\CategoryLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryLetters extends ListRecords
{
    protected static string $resource = CategoryLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
