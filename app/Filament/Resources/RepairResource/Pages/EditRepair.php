<?php

namespace App\Filament\Resources\RepairResource\Pages;

use App\Filament\Resources\RepairResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRepair extends EditRecord
{
    protected static string $resource = RepairResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
