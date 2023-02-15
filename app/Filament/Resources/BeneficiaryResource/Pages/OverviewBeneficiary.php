<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\Beneficiary\SidebarLayout;
use App\Contracts\Pages\WithSidebar;
use App\Enums\Beneficiary\Type;
use App\Filament\Resources\BeneficiaryResource;
use App\Forms\Components\Badge;
use App\Forms\Components\Card;
use App\Forms\Components\Location;
use App\Forms\Components\Placeholder;
use App\Forms\Components\Subsection;
use App\Models\Beneficiary;
use App\Models\Intervention;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class OverviewBeneficiary extends ViewRecord implements WithSidebar
{
    use SidebarLayout;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name;
    }

    protected function form(Form $form): Form
    {
        return match ($this->getRecord()->type) {
            Type::REGULAR => static::getRegularBeneficiaryForm($form),
            Type::OCASIONAL => static::getOcasionalBeneficiaryForm($form),
        };
    }

    protected static function getRegularBeneficiaryForm(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Card::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make(__('beneficiary.section.personal_data'))
                            ->columns(2)
                            ->schema([
                                Badge::make('status')
                                    ->content(fn (Beneficiary $record) => $record->status?->label())
                                    ->color(fn (Beneficiary $record) => $record->status?->color())
                                    ->columnSpanFull(),

                                Placeholder::make('id')
                                    ->label(__('field.beneficiary_id'))
                                    ->content(fn (Beneficiary $record) => $record->id),

                                Placeholder::make('integrated')
                                    ->label(__('field.integrated'))
                                    ->content('Placeholder content'),

                                Placeholder::make('household')
                                    ->label(__('field.household'))
                                    ->content('Placeholder content'),

                                Placeholder::make('family')
                                    ->label(__('field.family'))
                                    ->content('Placeholder content'),

                                Placeholder::make('age')
                                    ->label(__('field.age'))
                                    ->content(fn (Beneficiary $record) => $record->age),

                                Placeholder::make('gender')
                                    ->label(__('field.gender'))
                                    ->content(fn (Beneficiary $record) => $record->gender?->label()),

                                Placeholder::make('address')
                                    ->label(__('field.address'))
                                    ->content(fn (Beneficiary $record) => $record->full_address)
                                    ->columnSpanFull(),

                                Placeholder::make('phone')
                                    ->label(__('field.phone'))
                                    ->content(fn (Beneficiary $record) => $record->phone)
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Card::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make(__('beneficiary.section.active_interventions'))
                            ->schema([

                            ]),
                    ]),
            ]);
    }

    protected static function getOcasionalBeneficiaryForm(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->columnSpan(1)
                    ->schema([
                        Badge::make('type')
                            ->content(fn (Beneficiary $record) => $record->type?->label())
                            ->color(fn (Beneficiary $record) => $record->type?->color()),

                        Subsection::make()
                            ->icon('heroicon-o-user')
                            ->columns(2)
                            ->visible(fn (Beneficiary $record) => $record->has_unknown_identity)
                            ->schema([
                                Placeholder::make('has_unknown_identity')
                                    ->label(__('field.has_unknown_identity'))
                                    ->withoutContent()
                                    ->columnSpanFull(),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-user')
                            ->columns(2)
                            ->hidden(fn (Beneficiary $record) => $record->has_unknown_identity)
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
                                    ->content(fn (Beneficiary $record) => $record->cnp)
                                    ->fallback(__('field.does_not_have_cnp')),
                            ]),

                        static::getHouseholdSubsection(),

                        static::getLocationSubsection(),

                        Subsection::make()
                            ->icon('heroicon-o-lightning-bolt')
                            ->schema([
                                Repeater::make('interventions')
                                    ->relationship()
                                    ->label(__('intervention.label.plural'))
                                    ->columns(2)
                                    ->extraAttributes(['class' => '[ul]:divide-y'])
                                    ->schema([
                                        Placeholder::make('reason')
                                            ->label(__('field.intervention_reason'))
                                            ->content(fn (Intervention $record) => $record->reason),

                                        Placeholder::make('date')
                                            ->label(__('field.date'))
                                            ->content(fn (Intervention $record) => $record->date),

                                        Placeholder::make('services')
                                            ->label(__('field.services'))
                                            ->content(fn (Intervention $record) => $record->services->join(', ')),
                                    ]),
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
            ]);
    }

    private static function getHouseholdSubsection(): Subsection
    {
        return Subsection::make()
            ->icon('heroicon-o-user-group')
            ->columns(2)
            ->schema([
                Placeholder::make('household')
                    ->label(__('field.household')),

                Placeholder::make('family')
                    ->label(__('field.family')),
            ]);
    }

    private static function getLocationSubsection(): Subsection
    {
        return Subsection::make()
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
            ]);
    }
}
