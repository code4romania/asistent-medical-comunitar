<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\ProfileResourcesResource\RelationManagers\CoursesRelationManager;
use App\Forms\Components\Subsection;
use App\Models\User;
use Filament\Forms\Components\Placeholder;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewGeneral extends ViewRecord
{
    use ResolvesCurrentUserProfile;

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Subsection::make()
                    ->icon('heroicon-o-user')
                    ->schema([
                        Placeholder::make('first_name')
                            ->label($this->getTranslationLabel('first_name'))
                            ->content(fn (User $record) => $record->first_name),
                        Placeholder::make('last_name')
                            ->label($this->getTranslationLabel('last_name'))
                            ->content(fn (User $record) => $record->last_name),
                        Placeholder::make('date_of_birth')
                            ->label($this->getTranslationLabel('date_of_birth'))
                            ->content(fn (User $record) => $record->date_of_birth),
                        Placeholder::make('gender')
                            ->label($this->getTranslationLabel('gender'))
                            ->content(fn (User $record) => $this->getTranslationLabel($record->gender)),
                        Placeholder::make('cnp')
                            ->label($this->getTranslationLabel('cnp'))
                            ->content(fn (User $record) => $record->cnp),
                    ])
                    ->columns(2),

                Subsection::make()
                    ->icon('heroicon-o-location-marker')
                    ->schema([
                        Placeholder::make('county')
                            ->label($this->getTranslationLabel('county'))
                            ->content(fn (User $record) => 'Județ'),
                        Placeholder::make('city')
                            ->label($this->getTranslationLabel('city'))
                            ->content(fn (User $record) => 'City'),
                        Placeholder::make('email')
                            ->label($this->getTranslationLabel('email'))
                            ->content(fn (User $record) => $record->email),
                        Placeholder::make('phone')
                            ->label($this->getTranslationLabel('phone'))
                            ->content(fn (User $record) => $record->phone),

                    ])
                    ->columns(2),

                Subsection::make()
                    ->icon('heroicon-o-document')
                    ->schema([
                        Placeholder::make('accreditation_number')
                            ->content(fn (User $record) => $record->accreditation_number)
                            ->label($this->getTranslationLabel('accreditation_number')),
                        Placeholder::make('accreditation_date')
                            ->content(fn (User $record) => $record->accreditation_date)
                            ->label($this->getTranslationLabel('accreditation_date')),
                        Placeholder::make('accreditation_document')
                            ->label($this->getTranslationLabel('accreditation_document'))
                            ->content(fn (User $record) => null),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }

    protected function getRelationManagers(): array
    {
        return [
//            CoursesRelationManager::class
        ];
    }

    private function getTranslationLabel(string $key): string
    {

    }
}
