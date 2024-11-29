<?php

namespace App\Filament\Booking\Resources;

use App\Filament\Booking\Resources\OrderResource\Pages;
use App\Filament\Booking\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function getModelLabel(): string
    {
        return __('my booking');
    }

    public static function getNavigationLabel(): string
    {
        return __('My Bookings');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
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
                Tables\Columns\TextColumn::make('hotel.name')
                    ->label(__('Hotel name')),
                Tables\Columns\TextColumn::make('room.name')
                    ->label(__('Room name')),
                Tables\Columns\TextColumn::make('from_date')
                    ->label(__('From date'))
                    ->date(),
                Tables\Columns\TextColumn::make('to_date')
                    ->label(__('To date'))
                    ->date(),
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
