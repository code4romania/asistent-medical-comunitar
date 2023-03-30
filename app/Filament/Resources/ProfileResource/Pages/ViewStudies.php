<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\Profile\Study;
use Filament\Forms\Components\Repeater;
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
                                    ->label(__('field.study_name'))
                                    ->content(fn (Study $record) => $record->name),
                                Value::make('type')
                                    ->label(__('field.study_type'))
                                    ->content(fn (Study $record) => $record->type->label()),
                                Value::make('institution')
                                    ->label(__('field.study_institution'))
                                    ->content(fn (Study $record) => $record->institution),
                                Value::make('duration')
                                    ->label(__('field.study_duration'))
                                    ->content(fn (Study $record) => $record->duration),
                                Location::make(),
                                Value::make('start_year')
                                    ->label(__('field.start_year'))
                                    ->content(fn (Study $record) => $record->start_year),
                                Value::make('end_year')
                                    ->label(__('field.end_year'))
                                    ->content(fn (Study $record) => $record->end_year),
                            ]),
                    ]),
            ]);
    }
}
