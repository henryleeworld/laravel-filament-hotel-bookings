<?php

namespace App\Filament\Hotel\Resources\OrderResource\Pages;

use App\Filament\Hotel\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;
}
