<?php

namespace App\Filament\Booking\Pages;

use App\Filament\Booking\Resources\OrderResource;
use App\Models\Room;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class FindHotel extends Page implements HasForms, HasActions
{
    use InteractsWithActions, InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static string $view = 'filament.booking.pages.find-hotel';

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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
