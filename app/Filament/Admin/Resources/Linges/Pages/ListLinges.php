<?php

namespace App\Filament\Admin\Resources\Linges\Pages;

use App\Filament\Admin\Resources\Linges\LingeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLinges extends ListRecords
{
    protected static string $resource = LingeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
