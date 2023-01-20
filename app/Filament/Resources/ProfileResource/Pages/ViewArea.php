<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Forms\Components\Placeholder;
use App\Forms\Components\Subsection;
use App\Models\Profile\Area;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Form;
use Illuminate\Database\Eloquent\Builder;

class ViewArea extends ViewRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Repeater::make('areas')
                    ->relationship(callback: fn (Builder $query) => $query->withLocation())
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-location-marker')
                            ->columns(2)
                            ->schema([
                                Placeholder::make('county')
                                    ->label('user.profile.field.county')
                                    ->translateLabel()
                                    ->content(fn (Area $record) => $record->county?->name),
                                Placeholder::make('city')
                                    ->label('user.profile.field.city')
                                    ->translateLabel()
                                    ->content(fn (Area $record) => $record->city?->name),

                            ]),
                    ])
                    ->label('user.profile.section.area')
                    ->translateLabel()
                    ->defaultItems(1)
                    // ->createItemButtonLabel()
                    ->disableItemMovement(),
            ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
