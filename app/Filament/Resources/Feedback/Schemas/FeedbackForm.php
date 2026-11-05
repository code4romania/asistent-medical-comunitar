<?php

declare(strict_types=1);

namespace App\Filament\Resources\Feedback\Schemas;

use App\Models\FeedbackCategory;
use App\Models\FeedbackSubcategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class FeedbackForm
{
    public static function configure(Schema $schema): Schema
    {
        $subcategories = FeedbackSubcategory::allAsOptions();
        $activityCities = auth()->user()->activityCities
            ->pluck('formatted_name', 'id');

        return $schema
            ->components([
                Select::make('category_id')
                    ->label(__('field.category'))
                    ->options(fn () => FeedbackCategory::query()->pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('subcategory_id', null))
                    ->required(),

                Select::make('subcategory_id')
                    ->label(__('field.subcategory'))
                    ->options(fn (Get $get) => $subcategories->get($get('category_id')))
                    ->visible(fn (Get $get): bool => $subcategories->has($get('category_id')))
                    ->required(fn (Get $get): bool => $subcategories->has($get('category_id'))),

                Textarea::make('description')
                    ->label(__('field.notes'))
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),

                Select::make('city_id')
                    ->label(__('field.city'))
                    ->placeholder(__('placeholder.city'))
                    ->allowHtml()
                    ->searchable()
                    ->required()
                    ->options($activityCities)
                    ->in($activityCities->keys()),
            ]);
    }
}
