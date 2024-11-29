<?php

namespace App\Filament\Hotel\Resources;

use App\Filament\Resources\Hotel\OrderResource\Pages;
use App\Filament\Resources\Hotel\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('hotel_id', auth()->user()->hotel?->id);
    }

    public static function getModelLabel(): string
    {
        return __('order');
    }

    public static function getNavigationLabel(): string
    {
        return __('Orders');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Hotel\Resources\OrderResource\Pages\ListOrders::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('room.name')
                    ->label(__('Room name')),
                Tables\Columns\TextColumn::make('from_date')
                    ->label(__('From date'))
                    ->date(),
                Tables\Columns\TextColumn::make('to_date')
                    ->label(__('To date'))
                    ->date(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label(__('Customer name')),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Total price'))
                    ->money(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
