<?php

namespace App\Filament\Hotel\Resources\Rooms;

use App\Filament\Hotel\Resources\Rooms\Pages\CreateRoom;
use App\Filament\Hotel\Resources\Rooms\Pages\EditRoom;
use App\Filament\Hotel\Resources\Rooms\Pages\ListRooms;
use App\Filament\Hotel\Resources\Rooms\Schemas\RoomForm;
use App\Filament\Hotel\Resources\Rooms\Tables\RoomsTable;
use App\Models\Room;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function canCreate(): bool
    {
        return ! is_null(auth()->user()->hotel);
    }

    public static function form(Schema $schema): Schema
    {
        return RoomForm::configure($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('hotel_id', auth()->user()->hotel?->id);
    }

    public static function getModelLabel(): string
    {
        return __('room');
    }

    public static function getNavigationLabel(): string
    {
        return __('Rooms');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRooms::route('/'),
            'create' => CreateRoom::route('/create'),
            'edit' => EditRoom::route('/{record}/edit'),
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
        return RoomsTable::configure($table);
    }
}
