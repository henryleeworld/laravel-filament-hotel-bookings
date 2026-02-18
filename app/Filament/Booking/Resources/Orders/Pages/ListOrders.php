<?php

namespace App\Filament\Booking\Resources\Orders\Pages;

use App\Filament\Booking\Resources\Orders\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
