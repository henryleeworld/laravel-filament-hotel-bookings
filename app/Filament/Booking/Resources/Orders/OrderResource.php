<?php

namespace App\Filament\Booking\Resources\Orders;

use App\Filament\Booking\Resources\Orders\Pages\ListOrders;
use App\Filament\Booking\Resources\Orders\Schemas\OrderForm;
use App\Filament\Booking\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

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
            'index' => ListOrders::route('/'),
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
        return OrdersTable::configure($table);
    }
}
