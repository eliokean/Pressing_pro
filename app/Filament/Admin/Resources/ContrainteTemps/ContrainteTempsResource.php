<?php

namespace App\Filament\Admin\Resources\ContrainteTemps;

use App\Filament\Admin\Resources\ContrainteTemps\Pages\CreateContrainteTemps;
use App\Filament\Admin\Resources\ContrainteTemps\Pages\EditContrainteTemps;
use App\Filament\Admin\Resources\ContrainteTemps\Pages\ListContrainteTemps;
use App\Filament\Admin\Resources\ContrainteTemps\Schemas\ContrainteTempsForm;
use App\Filament\Admin\Resources\ContrainteTemps\Tables\ContrainteTempsTable;
use App\Models\ContrainteTemps;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContrainteTempsResource extends Resource
{
    protected static ?string $model = ContrainteTemps::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ContrainteTempsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContrainteTempsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContrainteTemps::route('/'),
            'create' => CreateContrainteTemps::route('/create'),
            'edit' => EditContrainteTemps::route('/{record}/edit'),
        ];
    }
}
