<x-filament-panels::page>
    <form wire:submit="save" class="max-w-3xl mx-auto w-full p-8 space-y-6">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getFormActions()"
         />
    </form>
</x-filament-panels::page>
