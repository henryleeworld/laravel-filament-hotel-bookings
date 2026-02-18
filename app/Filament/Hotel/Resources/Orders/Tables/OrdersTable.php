<?php

namespace App\Filament\Hotel\Resources\Orders\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room.name')
                    ->label(__('Room name')),
                TextColumn::make('from_date')
                    ->label(__('From date'))
                    ->date(),
                TextColumn::make('to_date')
                    ->label(__('To date'))
                    ->date(),
                TextColumn::make('customer.name')
                    ->label(__('Customer name')),
                TextColumn::make('price')
                    ->label(__('Total price'))
                    ->money(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
            ])
            ->toolbarActions([
            ]);
    }
}
