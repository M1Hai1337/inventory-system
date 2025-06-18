<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Allocation;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\RepeatableEntry;
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
                Section::make('Informations of Employee')
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
                    ->columns(6),
                Section::make('History of Equipments')
                    ->schema([
                        RepeatableEntry::make('allocations')
                            ->schema([
                                TextEntry::make('equipment.name')
                                    ->label('Equipment Name'),
                                TextEntry::make('equipment.description')
                                    ->label('Description')
                                    ->visible(fn($state): bool => !empty($state)),
                                TextEntry::make('equipment.category.name')
                                    ->label('Category'),
                                TextEntry::make('checkout_date')
                                    ->label('Checkout Date')
                                    ->dateTime('d.m.Y'),
                                TextEntry::make('return_date')
                                    ->label('Return Date')
                                    ->dateTime('d.m.Y')
                                    ->placeholder('unreturned'),
                                Actions::make([
                                    Action::make('return')
                                        ->label('Return')
                                        ->button()
                                        ->color('success')
                                        ->icon('heroicon-o-check-circle')
                                        ->visible(fn($record) => is_null($record->return_date))
                                        ->action(function (Allocation $record) {
                                            $record->return_date = now();
                                            $record->save();
                                        })
                                ])
                                    ->alignJustify()
                                    ->verticallyAlignCenter(),
                            ])
                            ->columns(6)
                    ])
            ]);
    }
}
