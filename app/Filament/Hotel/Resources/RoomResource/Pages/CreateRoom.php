<?php

namespace App\Filament\Hotel\Resources\RoomResource\Pages;

use App\Filament\Hotel\Resources\RoomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['hotel_id'] = auth()->user()->hotel->id;

        return $data;
    }
}
