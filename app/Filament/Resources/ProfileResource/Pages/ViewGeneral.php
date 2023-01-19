<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Forms\Components\Subsection;
use App\Models\User;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;

class ViewGeneral extends ViewRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Subsection::make()
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        Placeholder::make('first_name')
                            ->label(__('user.profile.field.first_name'))
                            ->content(fn (User $record) => $record->first_name),
                        Placeholder::make('last_name')
                            ->label(__('user.profile.field.last_name'))
                            ->content(fn (User $record) => $record->last_name),
                        Placeholder::make('date_of_birth')
                            ->label(__('user.profile.field.date_of_birth'))
                            ->content(fn (User $record) => $record->date_of_birth),
                        Placeholder::make('gender')
                            ->label(__('user.profile.field.gender'))
                            ->content(fn (User $record) => $record->gender->label()),
                        Placeholder::make('cnp')
                            ->label(__('user.profile.field.cnp'))
                            ->content(fn (User $record) => $record->cnp),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-location-marker')
                    ->columns(2)
                    ->schema([
                        Placeholder::make('county')
                            ->label(__('user.profile.field.county'))
                            ->content(fn (User $record) => $record->county_name),
                        Placeholder::make('city')
                            ->label(__('user.profile.field.city'))
                            ->content(fn (User $record) => $record->city_name),
                        Placeholder::make('email')
                            ->label(__('user.profile.field.email'))
                            ->content(fn (User $record) => $record->email),
                        Placeholder::make('phone')
                            ->label(__('user.profile.field.phone'))
                            ->content(fn (User $record) => $record->phone),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-document')
                    ->columns(2)
                    ->schema([
                        Placeholder::make('accreditation_number')
                            ->content(fn (User $record) => $record->accreditation_number)
                            ->label(__('user.profile.field.accreditation_number')),
                        Placeholder::make('accreditation_date')
                            ->content(fn (User $record) => $record->accreditation_date)
                            ->label(__('user.profile.field.accreditation_date')),
                        Placeholder::make('accreditation_document')
                            ->label(__('user.profile.field.accreditation_document'))
                            ->content(fn (User $record) => null),
                    ]),
            ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
