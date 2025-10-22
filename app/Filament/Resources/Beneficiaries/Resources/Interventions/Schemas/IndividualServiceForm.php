<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas;

use App\Enums\Intervention\Status;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Schemas\Components\Subsection;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Models\Service\Service;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class IndividualServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        $services = Service::allAsFlatOptions();

        return $schema
            ->components([
                Subsection::make()
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columns(2)
                    ->components([
                        Select::make('interventionable.service_id')
                            ->label(__('field.service'))
                            ->placeholder(__('placeholder.select_one'))
                            ->options($services)
                            ->optionsLimit($services->count())
                            ->in($services->keys())
                            ->searchable()
                            ->required(),

                        Select::make('vulnerability_id')
                            ->label(__('field.addressed_vulnerability'))
                            ->placeholder(__('placeholder.select_one'))
                            ->options(fn (Beneficiary|Intervention $record) => InterventionResource::getValidVulnerabilities($record))
                            ->in(fn (Beneficiary|Intervention $record) => InterventionResource::getValidVulnerabilities($record)?->keys())
                            ->searchable()
                            ->live()
                            ->required(),

                        Hidden::make('vulnerability_label')
                            ->afterStateHydrated(function (Set $set, $state, Beneficiary|Intervention $record) {
                                $vulnerability_id = InterventionResource::getValidVulnerabilities($record)
                                    ->filter(fn (string $value) => $value === $state)
                                    ->keys()
                                    ->first();

                                $set('vulnerability_id', $vulnerability_id);
                            }),

                        Select::make('interventionable.status')
                            ->label(__('field.status'))
                            ->options(Status::class)
                            ->default(Status::PLANNED)
                            ->required(),

                        DatePicker::make('interventionable.date')
                            ->label(__('field.date'))
                            ->minDate(fn () => InterventionResource::minReportingDate())
                            ->default(today())
                            ->required(),

                        Radio::make('integrated')
                            ->label(__('field.integrated'))
                            ->inline()
                            ->boolean()
                            ->default(0),

                        Checkbox::make('interventionable.outside_working_hours')
                            ->label(__('field.outside_working_hours'))
                            ->helperText(__('field.outside_working_hours_help')),
                    ]),

                Subsection::make()
                    ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                    ->schema([
                        Textarea::make('notes')
                            ->label(__('field.notes'))
                            ->maxLength(65535)
                            ->nullable()
                            ->autosize()
                            ->rows(4),
                    ]),
            ]);
    }
}
