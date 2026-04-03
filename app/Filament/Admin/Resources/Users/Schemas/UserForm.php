<?php

namespace App\Filament\Admin\Resources\Users\Schemas;


use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;


class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Mot de passe')
                    ->required()
                    ->password()
                    ->maxLength(255),
                
                //
            ]);
    }
}
