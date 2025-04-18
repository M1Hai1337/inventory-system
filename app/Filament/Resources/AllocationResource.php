<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllocationResource\Pages;
use App\Filament\Resources\AllocationResource\RelationManagers;
use App\Models\Allocation;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;

class AllocationResource extends Resource
{
    protected static ?string $model = Allocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $isCreating = request()->routeIs('filament.resources.allocations.create');

        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee')
                    ->getOptionLabelFromRecordUsing(fn(Employee $record) => "{$record->first_name} {$record->last_name}")
                    ->required(),
                Forms\Components\Select::make('equipment_id')
                    ->relationship('equipment', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('checkout_date')
                    ->default(now())
                    ->visible(!$isCreating)
                    ->disabled(!$isCreating)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->label('Employee Name')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->employee->first_name . ' ' . $record->employee->last_name;
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('checkout_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('return_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('return_date')
                ->label('Returned')
                ->nullable()
//                ->query(fn (Builder $query): Builder => $query->whereNotNull('return_date'))
            ])
            ->actions([
                Tables\Actions\Action::make('return')
                    ->label('Return')
                    ->visible(fn (Allocation $record) => $record->return_date === null)
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->action(function (Allocation $record) {
                        $record->update(['return_date' => now()]);
                    })
                    ->requiresConfirmation()
                    ->color('success'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAllocations::route('/'),
            'create' => Pages\CreateAllocation::route('/create'),
            'edit' => Pages\EditAllocation::route('/{record}/edit'),
        ];
    }
}
