<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Intervention\CaseInitiator;
use App\Enums\Intervention\Status;
use App\Filament\Resources\InterventionResource\Pages;
use App\Filament\Resources\InterventionResource\RelationManagers\InterventionsRelationManager;
use App\Forms\Components\Radio;
use App\Forms\Components\Subsection;
use App\Http\Middleware\RedirectToDashboard;
use App\Models\Beneficiary;
use App\Models\Catagraphy;
use App\Models\Intervention;
use App\Models\Service\Service;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class InterventionResource extends Resource
{
    protected static ?string $model = Intervention::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static string | array $routeMiddleware = [
        RedirectToDashboard::class,
    ];

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageInterventions::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            InterventionsRelationManager::class,
        ];
    }

    public static function getCaseFormSchema(int $columns = 2): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->columnSpan([
                    'lg' => $columns - 1,
                ])
                ->schema([
                    TextInput::make('interventionable.name')
                        ->label(__('field.intervention_name'))
                        ->required()
                        ->maxLength(200)
                        ->columnSpanFull(),

                    Select::make('interventionable.initiator')
                        ->label(__('field.initiator'))
                        ->placeholder(__('placeholder.choose'))
                        ->options(CaseInitiator::options())
                        ->enum(CaseInitiator::class)
                        ->default(CaseInitiator::NURSE)
                        ->required(),

                    Select::make('vulnerability_id')
                        ->label(__('field.addressed_vulnerability'))
                        ->placeholder(__('placeholder.select_one'))
                        ->options(fn ($livewire) => static::getValidVulnerabilities($livewire->getBeneficiary()))
                        ->in(fn ($livewire) => static::getValidVulnerabilities($livewire->getBeneficiary())?->keys())
                        ->searchable()
                        ->live()
                        ->required(),

                    Hidden::make('vulnerability_label')
                        ->afterStateHydrated(function (\Filament\Forms\Set $set, $state, $livewire) {
                            $vulnerability_id = static::getValidVulnerabilities($livewire->getBeneficiary())
                                ->filter(fn (string $value) => $value === $state)
                                ->keys()
                                ->first();

                            $set('vulnerability_id', $vulnerability_id);
                        }),

                    Radio::make('integrated')
                        ->label(__('field.integrated'))
                        ->inlineOptions()
                        ->boolean()
                        ->default(0),
                ]),

            Subsection::make()
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->columnSpan([
                    'lg' => 1,
                ])
                ->schema([
                    Textarea::make('notes')
                        ->label(__('field.notes'))
                        ->nullable()
                        ->maxLength(65535),
                ]),

            Subsection::make()
                ->icon('heroicon-o-clipboard-document-check')
                ->columnSpanFull()
                ->schema([
                    Textarea::make('interventionable.recommendations')
                        ->label(__('field.monitoring_recommendations'))
                        ->nullable()
                        ->maxLength(65535),
                ]),
        ];
    }

    public static function getIndividualServiceFormSchema(): array
    {
        $services = Service::allAsFlatOptions();

        return [
            Grid::make(2)
                ->schema([
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
                        ->options(fn ($livewire) => static::getValidVulnerabilities($livewire->getBeneficiary()))
                        ->in(fn ($livewire) => static::getValidVulnerabilities($livewire->getBeneficiary())?->keys())
                        ->searchable()
                        ->live()
                        ->required(),

                    Hidden::make('vulnerability_label')
                        ->afterStateHydrated(function (\Filament\Forms\Set $set, $state, $livewire) {
                            $vulnerability_id = static::getValidVulnerabilities($livewire->getBeneficiary())
                                ->filter(fn (string $value) => $value === $state)
                                ->keys()
                                ->first();

                            $set('vulnerability_id', $vulnerability_id);
                        }),

                    Select::make('interventionable.status')
                        ->label(__('field.status'))
                        ->options(Status::options())
                        ->enum(Status::class)
                        ->default(Status::PLANNED)
                        ->required(),

                    DatePicker::make('interventionable.date')
                        ->label(__('field.date'))
                        ->minDate(fn () => InterventionResource::minReportingDate())
                        ->default(today())
                        ->required(),

                    Radio::make('integrated')
                        ->label(__('field.integrated'))
                        ->inlineOptions()
                        ->boolean()
                        ->default(0),

                    Textarea::make('notes')
                        ->label(__('field.notes'))
                        ->autosize(false)
                        ->rows(4)
                        ->columnSpanFull()
                        ->extraInputAttributes([
                            'class' => 'resize-none',
                        ])
                        ->maxLength(65535),

                    Checkbox::make('interventionable.outside_working_hours')
                        ->label(__('field.outside_working_hours'))
                        ->helperText(__('field.outside_working_hours_help')),
                ]),
        ];
    }

    public static function getValidVulnerabilities(Beneficiary $beneficiary): Collection | null
    {
        return Cache::driver('array')
            ->remember(
                "valid-vulnerabilities-beneficiary-{$beneficiary->id}",
                MINUTE_IN_SECONDS,
                fn () => Catagraphy::whereBeneficiary($beneficiary)
                    ->first()
                    ?->all_valid_vulnerabilities
                    ->pluck('label')
            );
    }

    public static function hasValidVulnerabilities($livewire): bool
    {
        return static::getValidVulnerabilities($livewire->getBeneficiary())
            ?->isNotEmpty() ?? false;
    }

    public static function minReportingDate(): Carbon
    {
        if (today()->day > 5) {
            return today()->startOfMonth();
        }

        return today()->subMonth()->startOfMonth();
    }
}
