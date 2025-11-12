<?php

declare(strict_types=1);

namespace App\Filament\Resources\Recommendations\Schemas;

use App\Models\Vulnerability\Vulnerability;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class RecommendationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                TextInput::make('title')
                    ->label(__('field.recommendation_title'))
                    ->required(),

                Textarea::make('description')
                    ->label(__('field.recommendation_description'))
                    ->rows(4)
                    ->nullable(),

                Select::make('vulnerabilities')
                    ->label(__('field.recommendation_vulnerabilities'))
                    ->relationship('vulnerabilities', 'name', fn (Builder $query) => $query->with('category'))
                    ->getOptionLabelFromRecordUsing(fn (Vulnerability $record) => $record->name_with_category)
                    ->preload()
                    ->optionsLimit(100)
                    ->multiple()
                    ->required(),

                Select::make('services')
                    ->label(__('field.recommendation_services'))
                    ->relationship('services', 'name')
                    ->preload()
                    ->optionsLimit(100)
                    ->multiple()
                    ->required(),
            ]);
    }
}
