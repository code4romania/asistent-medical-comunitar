<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Enums\Gender;
use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Subsection;
use App\Rules\ValidCNP;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                            ->placeholder(__('placeholder.first_name'))
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('last_name')
                            ->label(__('field.last_name'))
                            ->placeholder(__('placeholder.last_name'))
                            ->maxLength(50)
                            ->required(),
                        DatePicker::make('date_of_birth')
                            ->label(__('field.date_of_birth'))
                            ->placeholder(__('placeholder.date'))
                            ->nullable(),
                        Select::make('gender')
                            ->label(__('field.gender'))
                            ->placeholder(__('placeholder.choose'))
                            ->options(Gender::options())
                            ->enum(Gender::class),
                        TextInput::make('cnp')
                            ->label(__('field.cnp'))
                            ->placeholder(__('placeholder.cnp'))
                            ->unique(ignoreRecord: true)
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
                            ->placeholder(__('placeholder.email'))
                            ->unique(ignoreRecord: true)
                            ->email()
                            ->maxLength(200)
                            ->required(),
                        TextInput::make('phone')
                            ->label(__('field.phone'))
                            ->placeholder(__('placeholder.phone'))
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
                            ->placeholder(__('placeholder.accreditation_number'))
                            ->nullable()
                            ->maxLength(200),

                        DatePicker::make('accreditation_date')
                            ->label(__('field.accreditation_date'))
                            ->placeholder(__('placeholder.date')),

                        SpatieMediaLibraryFileUpload::make('accreditation_document')
                            ->label(__('field.accreditation_document'))
                            ->collection('accreditation_document')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/jpeg',
                                'image/png',
                            ])
                            ->maxSize(1024 * 1024 * 5)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
