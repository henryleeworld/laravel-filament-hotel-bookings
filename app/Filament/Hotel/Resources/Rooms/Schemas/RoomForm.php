<?php

namespace App\Filament\Hotel\Resources\Rooms\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Room name'))
                    ->required(),
                TextInput::make('price')
                    ->label(__('Price'))
                    ->numeric()
                    ->step('0.01')
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->maxLength(1024)
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}
