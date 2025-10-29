<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Schemas;

use App\Filament\Infolists\Components\ServiceEntry;
use App\Filament\Infolists\Components\VulnerabilityChips;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\CatagraphyResource;
use App\Models\Catagraphy;
use App\Models\Recommendation;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\EmptyState;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Cache;

class SummaryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                static::vulnerabilities(),
                static::recommendations(),
            ]);
    }

    private static function vulnerabilities(): Section
    {
        return Section::make()
            ->heading(__('catagraphy.header.vulnerabilities'))
            ->headerActions([
                ViewAction::make()
                    ->label(__('catagraphy.action.view'))
                    ->visible(fn (Catagraphy $record) => filled($record->created_at))
                    ->url(fn (Catagraphy $record) => CatagraphyResource::getUrl('view', [
                        'beneficiary' => $record->beneficiary,
                    ]))
                    ->color('gray'),
            ])
            ->components(function (Catagraphy $record): array {
                if (blank($record->created_at)) {
                    return [
                        EmptyState::make(__('catagraphy.vulnerability.empty.title'))
                            ->description(__('catagraphy.vulnerability.empty.description'))
                            ->icon('icon-empty-state')
                            ->footer([
                                Action::make('create')
                                    ->label(__('catagraphy.vulnerability.empty.create'))
                                    ->url(CatagraphyResource::getUrl('edit', [
                                        'beneficiary' => $record->beneficiary,
                                    ]))
                                    ->button()
                                    ->color('gray'),
                            ]),
                    ];
                }

                return [
                    VulnerabilityChips::make('socioeconomic_vulnerabilities')
                        ->label(__('catagraphy.vulnerability.socioeconomic')),

                    VulnerabilityChips::make('health_vulnerabilities')
                        ->label(__('catagraphy.vulnerability.health')),

                    VulnerabilityChips::make('reproductive_health')
                        ->label(__('catagraphy.vulnerability.reproductive_health')),

                    VulnerabilityChips::make('suspicions')
                        ->label(__('catagraphy.vulnerability.suspicions')),
                ];
            })
            ->footer([
                View::make('catagraphy.last_updated')
                    ->visible(fn (Catagraphy $record) => filled($record->created_at))
                    ->viewData(fn (Catagraphy $record) => [
                        'created_at' => $record->created_at->toFormattedDateTime(),
                        'updated_at' => $record->updated_at->toFormattedDateTime(),
                        'name' => $record->nurse->full_name,
                        'history_url' => BeneficiaryResource::getUrl('history', [
                            'record' => $record->beneficiary,
                        ]),
                    ]),
            ]);
    }

    private static function recommendations(): Section
    {
        return Section::make()
            ->heading(__('catagraphy.header.recommendations'))
            ->components(function (Catagraphy $record): array {
                $recommendations = Cache::driver('array')
                    ->remember(
                        "recommendations-beneficiary-{$record->beneficiary_id}",
                        MINUTE_IN_SECONDS,
                        fn () => Recommendation::forVulnerabilities($record->all_valid_vulnerabilities->pluck('value'))
                    );

                if ($recommendations->isEmpty()) {
                    return [
                        EmptyState::make(__('catagraphy.recommendation.empty.title'))
                            ->description(__('catagraphy.recommendation.empty.description'))
                            ->icon('icon-clipboard'),
                    ];
                }

                return [
                    RepeatableEntry::make('recommendations')
                        ->hiddenLabel()
                        ->grid([
                            'default' => 1,
                            'md' => 2,
                            'lg' => 1,
                            'xl' => 2,
                            '2xl' => 3,
                        ])
                        ->state($recommendations)
                        ->contained(false)
                        ->components([
                            Section::make()
                                ->extraAttributes(['class' => 'shadow-lg'])
                                ->compact()
                                ->components([
                                    VulnerabilityChips::make('vulnerabilities')
                                        ->hiddenLabel(),

                                    TextEntry::make('title')
                                        ->extraAttributes(['class' => 'font-semibold'])
                                        ->size(TextSize::Large)
                                        ->hiddenLabel(),

                                    TextEntry::make('description')
                                        ->extraAttributes(['class' => 'text-gray-600 dark:text-gray-300'])
                                        ->lineClamp(2)
                                        ->hiddenLabel(),
                                ])
                                ->footerActions([
                                    Action::make('view')
                                        ->label(__('recommendation.action.view_services'))
                                        ->modalHeading(fn (Recommendation $record) => $record->title)
                                        ->schema([
                                            TextEntry::make('description')
                                                ->hiddenLabel(),

                                            VulnerabilityChips::make('vulnerabilities')
                                                ->label(__('field.recommendation_vulnerabilities')),

                                            ServiceEntry::make('services.name')
                                                ->label(__('field.recommendation_services')),
                                        ])
                                        ->modalFooterActions([])
                                        ->link(),
                                ]),
                        ]),
                ];
            });
    }
}
