<?php

namespace App\Filament\Resources\UnresolvedSearchLogResource\Pages;

use App\Filament\Resources\UnresolvedSearchLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnresolvedSearchLog extends EditRecord
{
    protected static string $resource = UnresolvedSearchLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
