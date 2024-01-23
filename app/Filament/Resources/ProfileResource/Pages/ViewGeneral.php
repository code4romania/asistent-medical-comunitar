<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
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
                        Value::make('username')
                            ->label(__('field.username'))
                            ->columnSpanFull(),

                        Value::make('first_name')
                            ->label(__('field.first_name')),

                        Value::make('last_name')
                            ->label(__('field.last_name')),

                        Value::make('date_of_birth')
                            ->label(__('field.date_of_birth')),

                        Value::make('gender')
                            ->label(__('field.gender')),

                        Value::make('cnp')
                            ->label(__('field.cnp')),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-location-marker')
                    ->columns(2)
                    ->schema([
                        Location::make(),
                        Value::make('email')
                            ->label(__('field.email')),

                        Value::make('phone')
                            ->label(__('field.phone')),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-document')
                    ->columns(2)
                    ->schema([
                        Value::make('accreditation_number')
                            ->label(__('field.accreditation_number')),

                        Value::make('accreditation_date')
                            ->label(__('field.accreditation_date')),

                        Value::make('accreditation_document')
                            ->label(__('field.accreditation_document')),
                    ]),
            ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
