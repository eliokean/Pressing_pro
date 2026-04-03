<?php

namespace App\Filament\Admin\Resources\Vehicules\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class VehiculeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Type de véhicule')
                    ->options([
                        'Voiture' => 'Voiture',
                        'Moto' => 'Moto',
                        'Vélo' => 'Vélo',
                    ]),
                TextInput::make('coefficient')
                    ->label('Coefficient de lavage')
                    ->required()
                    ->numeric()
                    ->minValue(0.01),
                //
            ]);
    }
}
