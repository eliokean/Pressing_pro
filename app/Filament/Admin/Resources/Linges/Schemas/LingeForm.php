<?php

namespace App\Filament\Admin\Resources\Linges\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class LingeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nom')
                    ->label('Nom du linge')
                    ->required()
                    ->maxLength(255),
                Select::make('categorie')
                    ->label('Catégorie')
                    ->required()
                    ->options([
                        'Vêtements' => 'Vêtements',
                        'Maisons' => 'Maisons',
                    ]),
                TextInput::make('prix')
                    ->label('Prix (en FCFA)')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                
                //
            ]);
    }
}
