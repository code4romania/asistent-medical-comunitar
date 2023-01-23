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
                    ->label('user.profile.section.studies')
                    ->translateLabel()
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-academic-cap')
                            ->columns(2)
                            ->schema([
                                Placeholder::make('name')
                                    ->label('user.profile.field.study.name')
                                    ->translateLabel()
                                    ->content(fn (Study $record) => $record->name),
                                Placeholder::make('type')
                                    ->label('user.profile.field.study.type')
                                    ->translateLabel()
                                    ->content(fn (Study $record) => $record->type?->label()),
                                Placeholder::make('institution')
                                    ->label('user.profile.field.study.institution')
                                    ->translateLabel()
                                    ->content(fn (Study $record) => $record->institution),
                                Placeholder::make('duration')
                                    ->label('user.profile.field.study.duration')
                                    ->translateLabel()
                                    ->content(fn (Study $record) => $record->duration),
                                Location::make(),
                                Placeholder::make('start_year')
                                    ->label('user.profile.field.start_date')
                                    ->translateLabel()
                                    ->content(fn (Study $record) => $record->start_year),
                                Placeholder::make('end_year')
                                    ->label('user.profile.field.end_date')
                                    ->translateLabel()
                                    ->content(fn (Study $record) => $record->end_year),
                            ]),
                    ]),
                // ->createItemButtonLabel(__('user.profile.field.add_studies_btn'))
            ]);
    }
}
