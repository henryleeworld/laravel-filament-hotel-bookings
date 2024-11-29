<?php

namespace App\Filament\Hotel\Pages;

use App\Models\Hotel;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;

class MyHotel extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.hotel.pages.my-hotel';
    public ?array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                TextInput::make('address')
                    ->label(__('Address'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->required(),
                FileUpload::make('photo')
                    ->label(__('Photo'))
                    ->image()
                    ->required(),
                Checkbox::make('is_published')
                    ->label(__('Is published')),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function getHeading(): string
    {
        return __('My Hotel');
    }

    public static function getNavigationLabel(): string
    {
        return __('My Hotel');
    }

    public function mount(): void
    {
        $this->form->fill(auth()->user()->hotel?->attributesToArray());
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            Hotel::updateOrCreate(['user_id' => auth()->id()], [
                'name'         => $data['name'],
                'address'      => $data['address'],
                'description'  => $data['description'],
                'photo'        => $data['photo'],
                'is_published' => $data['is_published'],
            ]);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
