<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Subsection;
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
                    ->label(__('user.profile.section.area'))
                    ->defaultItems(1)
                    ->disableItemMovement(),
            ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
