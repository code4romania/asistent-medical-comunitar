<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Enums\Gender;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Rules\ValidCNP;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;

class EditGeneral extends EditRecord
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
                        TextInput::make('first_name')
                            ->label(__('field.first_name'))
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('last_name')
                            ->label(__('field.last_name'))
                            ->maxLength(50)
                            ->required(),
                        DatePicker::make('date_of_birth')
                            ->label(__('field.date_of_birth'))
                            ->nullable(),
                        Select::make('gender')
                            ->label(__('field.gender'))
                            ->options(Gender::options())
                            ->disablePlaceholderSelection()
                            ->enum(Gender::class),
                        TextInput::make('cnp')
                            ->label(__('field.cnp'))
                            ->unique()
                            ->nullable()
                            ->rule(new ValidCNP),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-location-marker')
                    ->columns(2)
                    ->schema([
                        Location::make(),
                        TextInput::make('email')
                            ->label(__('field.email'))
                            ->email()
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('phone')
                            ->label(__('field.phone'))
                            ->tel()
                            ->required()
                            ->maxLength(15),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-document')
                    ->columns(2)
                    ->schema([
                        TextInput::make('accreditation_number')
                            ->label(__('field.accreditation_number'))
                            ->nullable()
                            ->maxLength(50),
                        DatePicker::make('accreditation_date')
                            ->label(__('field.accreditation_date')),
                        FileUpload::make('accreditation_document')
                            ->label(__('field.accreditation_document'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
