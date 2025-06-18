<?php

namespace App\Filament\Base;

use App\Filament\Base\Interfaces\FormBuilder;
use App\Filament\Base\Interfaces\InfoListBuilder;
use App\Filament\Base\Interfaces\TableBuilder;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

abstract class BaseResource extends Resource
{
    protected static ?string $infolistBuilder = null;

    protected static ?string $tableBuilder = null;

    protected static ?string $formBuilder = null;

    protected static ?string $modelLabelKey = null;

    protected static ?string $titleKey = null;

    protected static ?string $navigationLabelKey = null;

    protected static bool $descCreatedAt = true;

    public static function form(Form $form): Form
    {
        if (is_subclass_of(static::$formBuilder, FormBuilder::class)) {
            return static::$formBuilder::make($form);
        }

        return $form;
    }

    public static function table(Table $table): Table
    {
        if (is_subclass_of(static::$tableBuilder, TableBuilder::class)) {
            return static::$tableBuilder::make($table);
        }

        return $table;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        if (is_subclass_of(static::$infolistBuilder, InfoListBuilder::class)) {
            return static::$infolistBuilder::make($infolist);
        }

        return $infolist;
    }

    public static function getModelLabel(): string
    {
        return __(static::$modelLabelKey) ?? parent::getModelLabel();
    }

    public static function getTitle(): string
    {
        return __(static::$titleKey) ?? parent::getTitle();
    }

    public static function getNavigationGroup(): ?string
    {
        return __(static::$navigationLabelKey);
    }

//    public static function getEloquentQuery(): EloquentBuilder
//    {
//        if (static::$descCreatedAt) {
//            return parent::getEloquentQuery()->orderByDesc('created_at');
//        }
//
//        return parent::getEloquentQuery();
//    }
}
