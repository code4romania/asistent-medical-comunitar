<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\Beneficiary\SidebarLayout;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Forms\Components\Badge;
use App\Forms\Components\Card;
use App\Forms\Components\Location;
use App\Forms\Components\Placeholder;
use App\Forms\Components\Subsection;
use App\Models\Beneficiary;
use Filament\Forms\Components\Section;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewPersonalDataBeneficiary extends ViewRecord implements WithSidebar
{
    use SidebarLayout;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()
                ->url($this->getResource()::getUrl('personal_data.edit', $this->getRecord())),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name;
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->schema([
                        Badge::make('type')
                            ->color('text-indigo-800 bg-indigo-100')
                            ->content(fn (Beneficiary $record) => $record->type->label()),

                        Section::make(__('beneficiary.header.id'))
                            ->schema([
                                Subsection::make()
                                    ->icon('heroicon-o-user')
                                    ->columns(2)
                                    ->schema([
                                        Placeholder::make('first_name')
                                            ->label(__('field.first_name'))
                                            ->content(fn (Beneficiary $record) => $record->first_name),
                                        Placeholder::make('last_name')
                                            ->label(__('field.last_name'))
                                            ->content(fn (Beneficiary $record) => $record->last_name),
                                        Placeholder::make('gender')
                                            ->label(__('field.gender'))
                                            ->content(fn (Beneficiary $record) => $record->gender?->label()),
                                        Placeholder::make('cnp')
                                            ->label(__('field.cnp'))
                                            ->content(fn (Beneficiary $record) => $record->cnp),
                                    ]),

                                Subsection::make()
                                    ->icon('heroicon-o-user-group')
                                    ->columns(2)
                                    ->schema([
                                        Placeholder::make('household')
                                            ->label(__('field.household')),
                                        Placeholder::make('family')
                                            ->label(__('field.family')),
                                    ]),

                                Subsection::make()
                                    ->icon('heroicon-o-location-marker')
                                    ->columns(2)
                                    ->schema([
                                        Location::make(),
                                        Placeholder::make('address')
                                            ->label(__('field.address'))
                                            ->content(fn (Beneficiary $record) => $record->address),
                                        Placeholder::make('phone')
                                            ->label(__('field.phone'))
                                            ->content(fn (Beneficiary $record) => $record->phone),
                                    ]),

                                Subsection::make()
                                    ->icon('heroicon-o-annotation')
                                    ->schema([
                                        Placeholder::make('notes')
                                            ->label(__('field.beneficiary_notes'))
                                            ->extraAttributes(['class' => 'prose max-w-none'])
                                            ->content(fn (Beneficiary $record) => $record->notes),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
