<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\User;
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
                        Value::make('first_name')
                            ->label(__('field.first_name'))
                            ->content(fn (User $record) => $record->first_name),
                        Value::make('last_name')
                            ->label(__('field.last_name'))
                            ->content(fn (User $record) => $record->last_name),
                        Value::make('date_of_birth')
                            ->label(__('field.date_of_birth'))
                            ->content(fn (User $record) => $record->date_of_birth),
                        Value::make('gender')
                            ->label(__('field.gender'))
                            ->content(fn (User $record) => $record->gender->label()),
                        Value::make('cnp')
                            ->label(__('field.cnp'))
                            ->content(fn (User $record) => $record->cnp),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-location-marker')
                    ->columns(2)
                    ->schema([
                        Location::make(),
                        Value::make('email')
                            ->label(__('field.email'))
                            ->content(fn (User $record) => $record->email),
                        Value::make('phone')
                            ->label(__('field.phone'))
                            ->content(fn (User $record) => $record->phone),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-document')
                    ->columns(2)
                    ->schema([
                        Value::make('accreditation_number')
                            ->content(fn (User $record) => $record->accreditation_number)
                            ->label(__('field.accreditation_number')),
                        Value::make('accreditation_date')
                            ->content(fn (User $record) => $record->accreditation_date)
                            ->label(__('field.accreditation_date')),
                        Value::make('accreditation_document')
                            ->label(__('field.accreditation_document'))
                            ->content(fn (User $record) => null),
                    ]),
            ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
