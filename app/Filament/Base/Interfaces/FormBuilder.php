<?php

namespace App\Filament\Base\Interfaces;

use Filament\Forms\Form;

interface FormBuilder
{
    public static function make(Form $form, array $extraAttributes = []): Form;
}
