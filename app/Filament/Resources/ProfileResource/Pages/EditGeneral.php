<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Enums\Gender;
use App\Filament\Resources\ProfileResource;
use App\Forms\Components\Subsection;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class EditGeneral extends EditRecord
{
    use ResolvesCurrentUserProfile;

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Subsection::make()
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('first_name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        DatePicker::make('date_of_birth')
                            ->required(),
                        Select::make('gender')
                            ->options(Gender::values()),
                        TextInput::make('cnp')
                            ->length(13),
                    ])
                    ->columns(2),

                Subsection::make()
                    ->icon('heroicon-o-location-marker')
                    ->schema([
                        Placeholder::make('county')
                            ->content(fn (User $record) => 'Județ'),
                        Placeholder::make('city')
                            ->content(fn (User $record) => 'City'),
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->tel()
                            ->required(),

                    ])
                    ->columns(2),

                Subsection::make()
                    ->icon('heroicon-o-document')
                    ->schema([
                        TextInput::make('accreditation_number'),
                        DatePicker::make('accreditation_date'),
                        // FileUpload::make('accreditation_document')
                        //     ->columnSpanFull(),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('general.view');
    }
}
