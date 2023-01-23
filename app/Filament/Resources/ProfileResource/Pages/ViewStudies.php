<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Forms\Components\Location;
use App\Forms\Components\Placeholder;
use App\Forms\Components\Subsection;
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
                                Placeholder::make('name')
                                    ->label(__('user.profile.field.study.name'))
                                    ->content(fn (Study $record) => $record->name),
                                Placeholder::make('type')
                                    ->label(__('user.profile.field.study.type'))
                                    ->content(fn (Study $record) => $record->type->label()),
                                Placeholder::make('institution')
                                    ->label(__('user.profile.field.study.institution'))
                                    ->content(fn (Study $record) => $record->institution),
                                Placeholder::make('duration')
                                    ->label(__('user.profile.field.study.duration'))
                                    ->content(fn (Study $record) => $record->duration),
                                Location::make(),
                                Placeholder::make('start_year')
                                    ->label(__('user.profile.field.start_year'))
                                    ->content(fn (Study $record) => $record->start_year),
                                Placeholder::make('end_year')
                                    ->label(__('user.profile.field.end_year'))
                                    ->content(fn (Study $record) => $record->end_year),
                            ]),
                    ]),
            ]);
    }
}
