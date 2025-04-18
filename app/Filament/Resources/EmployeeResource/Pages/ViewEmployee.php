<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informations')
                ->schema([
                    TextEntry::make('first_name')
                    ->label('First Name'),
                    TextEntry::make('last_name')
                    ->label('Last Name'),
                    TextEntry::make('email')
                    ->label('Email'),
                    TextEntry::make('age')
                    ->label('Age'),
                    TextEntry::make('address')
                    ->label('Address'),
                ])
                ->columns()
            ]);
    }
}
