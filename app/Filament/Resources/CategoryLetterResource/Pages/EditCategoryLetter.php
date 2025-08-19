<?php

namespace App\Filament\Resources\CategoryLetterResource\Pages;

use App\Filament\Resources\CategoryLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryLetter extends EditRecord
{
    protected static string $resource = CategoryLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
