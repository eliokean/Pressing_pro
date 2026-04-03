<?php

namespace App\Filament\Admin\Resources\Vehicules;

use App\Filament\Admin\Resources\Vehicules\Pages\CreateVehicule;
use App\Filament\Admin\Resources\Vehicules\Pages\EditVehicule;
use App\Filament\Admin\Resources\Vehicules\Pages\ListVehicules;
use App\Filament\Admin\Resources\Vehicules\Schemas\VehiculeForm;
use App\Filament\Admin\Resources\Vehicules\Tables\VehiculesTable;
use App\Models\Vehicule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VehiculeResource extends Resource
{
    protected static ?string $model = Vehicule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return VehiculeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehiculesTable::configure($table);
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
            'index' => ListVehicules::route('/'),
            'create' => CreateVehicule::route('/create'),
            'edit' => EditVehicule::route('/{record}/edit'),
        ];
    }
}
