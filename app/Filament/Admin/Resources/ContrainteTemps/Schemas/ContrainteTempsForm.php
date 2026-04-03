<?php

namespace App\Filament\Admin\Resources\ContrainteTemps\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class ContrainteTempsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations de la contrainte')
                    ->description('Définissez les paramètres de la contrainte météo/temporelle')
                    ->schema([
                        TextInput::make('label')
                            ->label('Libellé')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ex: Pluie, Nuit, Canicule...')
                            ->unique(ignoreRecord: true)
                            ->helperText('Nom unique de la contrainte'),
                        
                        TextInput::make('coefficient')
                            ->label('Coefficient')
                            ->required()
                            ->numeric()
                            ->minValue(0.1)
                            ->maxValue(5.0)
                            ->step(0.01)
                            ->default(1.0)
                            ->helperText('Coefficient multiplicateur (ex: 1.3 = +30%, 0.8 = -20%)')
                            ->suffix('x'),
                        
                        Toggle::make('actif')
                            ->label('Actif')
                            ->default(true)
                            ->helperText('Désactivez pour ne plus utiliser cette contrainte'),
                    ])->columns(2),
            ]);
    }
}