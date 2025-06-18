<?php

namespace App\Filament\Resources\EmployeeResource\Forms;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

//use Laravel\Prompts\FormBuilder;
use App\Filament\Base\Interfaces\FormBuilder;

class EmployeeForm implements FormBuilder
{

    public static function make(Form $form, array $extraAttributes = []): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('age')
                    ->required()
                    ->numeric(),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
