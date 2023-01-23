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
                            ->label(__('user.profile.field.first_name'))
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('last_name')
                            ->label(__('user.profile.field.last_name'))
                            ->maxLength(50)
                            ->required(),
                        DatePicker::make('date_of_birth')
                            ->label(__('user.profile.field.date_of_birth'))
                            ->nullable(),
                        Select::make('gender')
                            ->label(__('user.profile.field.gender'))
                            ->options(Gender::options())
                            ->disablePlaceholderSelection()
                            ->enum(Gender::class),
                        TextInput::make('cnp')
                            ->label(__('user.profile.field.cnp'))
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
                            ->email()
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(15),
                    ]),

                Subsection::make()
                    ->icon('heroicon-o-document')
                    ->columns(2)
                    ->schema([
                        TextInput::make('accreditation_number')
                            ->nullable()
                            ->maxLength(50),
                        DatePicker::make('accreditation_date'),
                        FileUpload::make('accreditation_document')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
