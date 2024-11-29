<?php

namespace App\Filament\Hotel\Resources;

use App\Filament\Resources\Hotel\RoomResource\Pages;
use App\Filament\Resources\Hotel\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return ! is_null(auth()->user()->hotel);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Room name'))
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label(__('Price'))
                    ->numeric()
                    ->required()
                    ->step('0.01'),
                Forms\Components\Textarea::make('description')
                    ->label(__('Description'))
                    ->required()
                    ->columnSpanFull(),
            ]);
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
            'index' => \App\Filament\Hotel\Resources\RoomResource\Pages\ListRooms::route('/'),
            'create' => \App\Filament\Hotel\Resources\RoomResource\Pages\CreateRoom::route('/create'),
            'edit' => \App\Filament\Hotel\Resources\RoomResource\Pages\EditRoom::route('/{record}/edit'),
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
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Room name')),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Price'))
                    ->money(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
