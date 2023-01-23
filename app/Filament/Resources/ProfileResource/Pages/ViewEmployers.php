<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Forms\Components\Location;
use App\Forms\Components\Placeholder;
use App\Forms\Components\Subsection;
use App\Models\Profile\Employer;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Form;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ViewEmployers extends ViewRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('employers')
                    ->relationship(callback: fn (Builder $query) => $query->withLocation())
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-office-building')
                            ->columns(2)
                            ->schema([
                                Placeholder::make('name')
                                    ->label(__('user.profile.field.employer.name'))
                                    ->content(fn (Employer $record) => $record->name),
                                Placeholder::make('type')
                                    ->label(__('user.profile.field.employer.type'))
                                    ->content(fn (Employer $record) => $record->type->label()),
                                Placeholder::make('project')
                                    ->label(__('user.profile.field.employer.project'))
                                    ->content(fn (Employer $record) => $record->project)
                                    ->hidden(fn (Employer $record) => empty($record->project))
                                    ->columnSpanFull(),
                                Location::make(),
                                Placeholder::make('start_date')
                                    ->label(__('user.profile.field.start_date'))
                                    ->content(fn (Employer $record) => $record->start_date),
                                Placeholder::make('end_date')
                                    ->label(__('user.profile.field.end_date'))
                                    ->content(fn (Employer $record) => $record->end_date ?? __('user.profile.field.employer.ongoing')),
                            ]),
                    ])
                    ->label(__('user.profile.section.employers')),
            ])
            ->columns(1);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
