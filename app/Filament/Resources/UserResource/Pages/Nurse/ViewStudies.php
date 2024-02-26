<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Repeater;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use Filament\Resources\Form;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ViewStudies extends ViewRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Repeater::make('studies')
                    ->relationship(callback: fn (Builder $query) => $query->withLocation())
                    ->label(__('user.profile.section.studies'))
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-academic-cap')
                            ->columns(2)
                            ->schema([
                                Value::make('name')
                                    ->label(__('field.study_name')),

                                Value::make('type')
                                    ->label(__('field.study_type')),

                                Value::make('institution')
                                    ->label(__('field.study_institution')),

                                Value::make('duration')
                                    ->label(__('field.study_duration')),

                                Location::make(),

                                Value::make('start_year')
                                    ->label(__('field.start_year')),

                                Value::make('end_year')
                                    ->label(__('field.end_year')),
                            ]),
                    ]),
            ]);
    }
}
