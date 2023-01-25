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
                    ->label(__('employer.label.plural'))
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-office-building')
                            ->columns(2)
                            ->schema([
                                Placeholder::make('name')
                                    ->label(__('field.employer_name'))
                                    ->content(fn (Employer $record) => $record->name),
                                Placeholder::make('type')
                                    ->label(__('field.employer_type'))
                                    ->content(fn (Employer $record) => $record->type->label()),
                                Placeholder::make('project')
                                    ->label(__('field.employer_project'))
                                    ->content(fn (Employer $record) => $record->project)
                                    ->hidden(fn (Employer $record) => empty($record->project))
                                    ->columnSpanFull(),
                                Location::make(),
                                Placeholder::make('start_date')
                                    ->label(__('field.start_date'))
                                    ->content(fn (Employer $record) => $record->start_date),
                                Placeholder::make('end_date')
                                    ->label(__('field.end_date'))
                                    ->content(fn (Employer $record) => $record->end_date ?? __('field.employer_ongoing')),
                            ]),
                    ]),
            ])
            ->columns(1);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
