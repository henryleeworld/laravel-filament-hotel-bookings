<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="searchRooms" class="max-w-3xl mx-auto w-full p-8 space-y-6">
            {{ $this->form }}
            <x-filament::button type="submit" class="mt-3">
                {{ __('Search') }}
            </x-filament::button>
        </form>
    </x-filament::section>

    @if(! is_null($rooms))
        <div class="fi-ta-content-ctn fi-fixed-positioning-context">
            <table class="fi-ta-table">
                @if(count($rooms) === 0)
                    <div class="fi-ta-empty-state">
                        {{ __('No rooms have been found') }}
                    </div>
                @else
                    <tr name="header">
                        <th class="fi-ta-header-cell" name="hotel name">
                            {{ __('Hotel name') }}
                        </th>
                        <th class="fi-ta-header-cell">
                            {{ __('Room name') }}
                        </th>
                        <th class="fi-ta-header-cell">
                            {{ __('Price') }}
                        </th>
                        <th class="fi-ta-header-cell">
                        </th>
                    </tr>
                    @foreach($rooms as $room)
                        <tr class="fi-ta-row fi-ta-row-not-reorderable">
                            <td class="fi-ta-cell">
                                <div class="fi-ta-text grid gap-y-1 px-3 py-4">
                                    <div class="fi-ta-text-item inline-flex items-center gap-1.5">
                                        {{ $room->hotel->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="fi-ta-cell">
                                <div class="fi-ta-text grid gap-y-1 px-3 py-4">
                                    <div class="fi-ta-text-item inline-flex items-center gap-1.5">
                                        {{ $room->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="fi-ta-cell">
                                <div class="fi-ta-text grid gap-y-1 px-3 py-4">
                                    <div class="fi-ta-text-item inline-flex items-center gap-1.5">
                                        {{ \Filament\Support\format_money($room->price, 'USD') }}
                                    </div>
                                </div>
                            </td>
                            <td class="fi-ta-cell">
                                {{ ($this->bookAction)(['room' => $room->id]) }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    @endif
</x-filament-panels::page>
