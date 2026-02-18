<?php

namespace App\Filament\Booking\Pages;

use App\Filament\Booking\Resources\Orders\OrderResource;
use App\Models\Room;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class FindHotel extends Page implements HasActions, HasSchemas
{
    use InteractsWithActions, InteractsWithSchemas;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlassCircle;

    protected string $view = 'filament.app.booking.pages.find-hotel';

    public ?array $data = [];

    public ?Collection $rooms = null;

    public function bookAction(): Action
    {
        return
            Action::make('book')
                ->label(__('Book now'))
                ->requiresConfirmation()
                ->action(function (array $arguments) {
                    $formState = $this->form->getState();
                    $days = Carbon::parse($formState['from_date'])->diffInDays($formState['to_date']);
                    $room = Room::find($arguments['room']);

                    $room->orders()->create([
                        'hotel_id'  => $room->hotel_id,
                        'user_id'   => auth()->id(),
                        'from_date' => $formState['from_date'],
                        'to_date'   => $formState['to_date'],
                        'price'     => $days * $room->price,
                    ]);

                    $this->redirect(OrderResource::getUrl());
                });
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns()
                    ->schema([
                        DatePicker::make('from_date')
                            ->label(__('From date'))
                            ->required(),
                        DatePicker::make('to_date')
                            ->label(__('To date'))
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function getHeading(): string
    {
        return __('Find Hotel');
    }

    public static function getNavigationLabel(): string
    {
        return __('Find Hotel');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function searchRooms(): void
    {
        $formState = $this->form->getState();

        $this->rooms = Room::query()
            ->with('hotel')
            ->where(function (Builder $query) {
                return $query->whereHas('hotel', fn(Builder $query) => $query->where('is_published', true))
                    ->whereIn('price', Room::selectRaw('hotel_id, min(price)')
                        ->groupBy('hotel_id')
                        ->pluck('min(price)')
                    );
            })
            ->where(function (Builder $query) use ($formState) {
                return $query->whereDoesntHave('orders', function (Builder $query) use ($formState) {
                    return $query->whereBetween('from_date', [$formState['from_date'], $formState['to_date']])
                        ->orWhereBetween('to_date', [$formState['from_date'], $formState['to_date']]);
                });
            })
            ->get();
    }
}
