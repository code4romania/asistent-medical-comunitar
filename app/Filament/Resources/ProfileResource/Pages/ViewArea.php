<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
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
                                Location::make(),
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
