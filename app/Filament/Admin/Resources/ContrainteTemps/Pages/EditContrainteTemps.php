<?php

namespace App\Filament\Admin\Resources\ContrainteTemps\Pages;

use App\Filament\Admin\Resources\ContrainteTemps\ContrainteTempsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContrainteTemps extends EditRecord
{
    protected static string $resource = ContrainteTempsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
