<?php

namespace App\Filament\Admin\Resources\Linges;

use App\Filament\Admin\Resources\Linges\Pages\CreateLinge;
use App\Filament\Admin\Resources\Linges\Pages\EditLinge;
use App\Filament\Admin\Resources\Linges\Pages\ListLinges;
use App\Filament\Admin\Resources\Linges\Schemas\LingeForm;
use App\Filament\Admin\Resources\Linges\Tables\LingesTable;
use App\Models\Linge;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LingeResource extends Resource
{
    protected static ?string $model = Linge::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LingeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LingesTable::configure($table);
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
            'index' => ListLinges::route('/'),
            'create' => CreateLinge::route('/create'),
            'edit' => EditLinge::route('/{record}/edit'),
        ];
    }
}
