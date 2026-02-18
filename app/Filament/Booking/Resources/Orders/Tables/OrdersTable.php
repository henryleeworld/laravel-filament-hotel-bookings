<?php

namespace App\Filament\Booking\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hotel.name')
                    ->label(__('Hotel name')),
                TextColumn::make('room.name')
                    ->label(__('Room name')),
                TextColumn::make('from_date')
                    ->label(__('From date'))
                    ->date(),
                TextColumn::make('to_date')
                    ->label(__('To date'))
                    ->date(),
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
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
