<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Enums\Beneficiary\IDType;
use App\Forms\Components\Household;
use App\Forms\Components\Location;
use App\Forms\Components\Repeater;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\Beneficiary;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

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
                        ->fallback(fn (Beneficiary $record) => static::getCnpFallback($record)),

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
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
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
                                ->fallback(fn (Beneficiary $record) => static::getCnpFallback($record)),
                        ]),
                ]),

            Household::make(),

            static::getLocationSubsection(),

            Subsection::make()
                ->icon('heroicon-o-bolt')
                ->schema([
                    Repeater::make('ocasionalInterventions')
                        ->relationship(
                            callback: fn (Builder $query) => $query->with('services')
                        )
                        ->label(__('intervention.label.plural'))
                        ->columns(2)
                        ->schema([
                            Value::make('reason')
                                ->label(__('field.intervention_name')),

                            Value::make('date')
                                ->label(__('field.date')),

                            Value::make('services')
                                ->label(__('field.services_offered'))
                                ->columnSpanFull(),
                        ]),
                ]),

            Subsection::make()
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
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
            ->icon('heroicon-o-map-pin')
            ->columns(2)
            ->schema([
                Location::make(),

                Value::make('address')
                    ->label(__('field.address')),

                Value::make('phone')
                    ->label(__('field.phone')),
            ]);
    }

    private static function getCnpFallback(Beneficiary $beneficiary): string | Htmlable
    {
        if ($beneficiary->does_not_provide_cnp) {
            return __('field.does_not_provide_cnp');
        }

        if ($beneficiary->does_not_have_cnp) {
            return __('field.does_not_have_cnp');
        }

        return new HtmlString('&mdash;');
    }
}
