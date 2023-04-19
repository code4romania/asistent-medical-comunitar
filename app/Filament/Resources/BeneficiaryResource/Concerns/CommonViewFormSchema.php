<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Enums\Beneficiary\IDType;
use App\Forms\Components\Household;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\Beneficiary;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;

trait CommonViewFormSchema
{
    protected static function getRegularBeneficiaryFormSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    Value::make('first_name')
                        ->label(__('field.first_name')),

                    Value::make('last_name')
                        ->label(__('field.last_name')),

                    Value::make('cnp')
                        ->label(__('field.cnp'))
                        ->fallback(__('field.does_not_have_cnp')),

                    Value::make('id_type')
                        ->label(__('field.id_type')),

                    Group::make()
                        ->columns()
                        ->columnSpanFull()
                        ->hidden(fn (Beneficiary $record) => $record->id_type?->is(IDType::NONE))
                        ->schema([
                            Value::make('id_serial')
                                ->label(__('field.id_serial')),

                            Value::make('id_number')
                                ->label(__('field.id_number')),
                        ]),

                    Value::make('gender')
                        ->label(__('field.gender')),

                    Value::make('date_of_birth')
                        ->label(__('field.date_of_birth')),

                    Value::make('ethnicity')
                        ->label(__('field.ethnicity')),

                    Value::make('work_status')
                        ->label(__('field.work_status')),
                ]),

            Household::make(),

            static::getLocationSubsection(),

            Subsection::make()
                ->icon('heroicon-o-annotation')
                ->schema([
                    Value::make('notes')
                        ->label(__('field.beneficiary_notes'))
                        ->extraAttributes(['class' => 'prose max-w-none']),
                ]),

        ];
    }

    protected static function getOcasionalBeneficiaryFormSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    Value::make('unknown_identity') // don't set this to 'has_unknown_identity'
                        ->fallback(__('field.has_unknown_identity'))
                        ->visible(fn (Beneficiary $record) => $record->has_unknown_identity)
                        ->disableLabel(),

                    Grid::make()
                        ->hidden(fn (Beneficiary $record) => $record->has_unknown_identity)
                        ->schema([
                            Value::make('first_name')
                                ->label(__('field.first_name')),

                            Value::make('last_name')
                                ->label(__('field.last_name')),

                            Value::make('gender')
                                ->label(__('field.gender')),

                            Value::make('cnp')
                                ->label(__('field.cnp'))
                                ->fallback(__('field.does_not_have_cnp')),
                        ]),
                ]),

            Household::make(),

            static::getLocationSubsection(),

            Subsection::make()
                ->icon('heroicon-o-lightning-bolt')
                ->schema([
                    Repeater::make('interventions')
                        ->relationship()
                        ->label(__('intervention.label.plural'))
                        ->columns(2)
                        ->schema([
                            Value::make('reason')
                                ->label(__('field.intervention_reason')),

                            Value::make('date')
                                ->label(__('field.date')),

                            Value::make('services')
                                ->label(__('field.services'))
                                ->columnSpanFull(),
                        ]),
                ]),

            Subsection::make()
                ->icon('heroicon-o-annotation')
                ->schema([
                    Value::make('notes')
                        ->label(__('field.beneficiary_notes'))
                        ->extraAttributes(['class' => 'prose max-w-none']),
                ]),

        ];
    }

    private static function getLocationSubsection(): Subsection
    {
        return Subsection::make()
            ->icon('heroicon-o-location-marker')
            ->columns(2)
            ->schema([
                Location::make(),

                Value::make('address')
                    ->label(__('field.address')),

                Value::make('phone')
                    ->label(__('field.phone')),
            ]);
    }
}
