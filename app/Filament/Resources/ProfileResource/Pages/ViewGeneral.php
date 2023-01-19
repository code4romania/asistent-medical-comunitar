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
                            ->label('user.profile.field.first_name')
                            ->translateLabel()
                            ->content(fn (User $record) => $record->first_name),
                        Placeholder::make('last_name')
                            ->label('user.profile.field.last_name')
                            ->translateLabel()
                            ->content(fn (User $record) => $record->last_name),
                        Placeholder::make('date_of_birth')
                            ->label('user.profile.field.date_of_birth')
                            ->translateLabel()
                            ->content(fn (User $record) => $record->date_of_birth),
                        Placeholder::make('gender')
                            ->label('user.profile.field.gender')
                            ->translateLabel()
                            ->content(fn (User $record) => $record->gender->label()),
                        Placeholder::make('cnp')
                            ->label('user.profile.field.cnp')
                            ->translateLabel()
                            ->content(fn (User $record) => $record->cnp),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-location-marker')
                    ->columns(2)
                    ->schema([
                        Placeholder::make('county')
                            ->label('user.profile.field.county')
                            ->translateLabel()
                            ->content(fn (User $record) => $record->county_name),
                        Placeholder::make('city')
                            ->label('user.profile.field.city')
                            ->translateLabel()
                            ->content(fn (User $record) => $record->city_name),
                        Placeholder::make('email')
                            ->label('user.profile.field.email')
                            ->translateLabel()
                            ->content(fn (User $record) => $record->email),
                        Placeholder::make('phone')
                            ->label('user.profile.field.phone')
                            ->translateLabel()
                            ->content(fn (User $record) => $record->phone),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-document')
                    ->columns(2)
                    ->schema([
                        Placeholder::make('accreditation_number')
                            ->content(fn (User $record) => $record->accreditation_number)
                            ->label('user.profile.field.accreditation_number')
                            ->translateLabel(),
                        Placeholder::make('accreditation_date')
                            ->content(fn (User $record) => $record->accreditation_date)
                            ->label('user.profile.field.accreditation_date')
                            ->translateLabel(),
                        Placeholder::make('accreditation_document')
                            ->label('user.profile.field.accreditation_document')
                            ->translateLabel()
                            ->content(fn (User $record) => null),
                    ]),
            ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
