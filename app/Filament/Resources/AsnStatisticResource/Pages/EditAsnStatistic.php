<?php

namespace App\Filament\Resources\AsnStatisticResource\Pages;

use App\Filament\Resources\AsnStatisticResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsnStatistic extends EditRecord
{
    protected static string $resource = AsnStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
