<?php

namespace App\Filament\Hotel\Resources\Orders;

use App\Filament\Hotel\Resources\Orders\Pages\ListOrders;
use App\Filament\Hotel\Resources\Orders\Schemas\OrderForm;
use App\Filament\Hotel\Resources\Orders\Tables\OrdersTable;
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

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
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
