<?php

namespace App\Filament\Hotel\Auth\Pages;

use Filament\Auth\Pages\Register as RegisterPage;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;

class Register extends RegisterPage
{
    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label(__('Hotel name'))
            ->maxLength(255)
            ->autofocus()
            ->required();
    }
}
