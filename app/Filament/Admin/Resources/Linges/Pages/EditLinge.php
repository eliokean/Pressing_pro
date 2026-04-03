<?php

namespace App\Filament\Admin\Resources\Linges\Pages;

use App\Filament\Admin\Resources\Linges\LingeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLinge extends EditRecord
{
    protected static string $resource = LingeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
