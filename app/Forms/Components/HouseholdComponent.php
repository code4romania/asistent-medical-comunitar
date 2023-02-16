<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Models\Family;
use App\Models\Household;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class HouseholdComponent extends Grid
{
    public function getChildComponents(): array
    {
        return match ($this->getContainer()->getContext()) {
            'view' => $this->getViewComponents(),
            default => $this->getEditComponents(),
        };
    }

    protected function getViewComponents(): array
    {
        return [
            Placeholder::make('household')
                ->label(__('field.household'))
                ->content(fn ($record) => $record->household?->name),
            Placeholder::make('family')
                ->label(__('field.family'))
                ->content(fn ($record) => static::getRenderedOptionLabel($record->family)),
        ];
    }

    protected function getEditComponents(): array
    {
        return [
            Select::make('household_id')
                ->label(__('field.household'))
                ->placeholder(__('placeholder.household'))
                ->options(function () {
                    return Cache::driver('array')
                        ->rememberForever(
                            'household',
                            fn () => Household::pluck('name', 'id')
                        );
                })
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('family_id', null))
                ->createOptionForm([
                    TextInput::make('name'),

                ]),

            Select::make('family_id')
                ->label(__('field.family'))
                ->placeholder(__('placeholder.family'))
                ->allowHtml()
                ->searchable()
                ->requiredWith('household_id')
                ->getSearchResultsUsing(function (string $search, callable $get) {
                    $householderId = (int) $get('household_id');

                    if (! $householderId) {
                        return null;
                    }

                    return Family::query()
                        ->where('household_id', $householderId)
                        ->search($search)
                        ->limit(100)
                        ->get()
                        ->mapWithKeys(fn (Family $family) => [
                            $family->getKey() => $family->name,
                        ]);
                }),

        ];
    }

    private static function getRenderedOptionLabel(?Model $model): ?HtmlString
    {
        return new HtmlString($model->name);
    }
}
