<?php

namespace App\Filament\Admin\Resources\ContrainteTemps\Pages;

use App\Filament\Admin\Resources\ContrainteTemps\ContrainteTempsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContrainteTemps extends ListRecords
{
    protected static string $resource = ContrainteTempsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
