<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Models\Catagraphy;
use App\Models\Recommendation;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\View;
use Illuminate\Support\Facades\Cache;

class RecommendationsSection extends Card
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->header(__('catagraphy.header.recommendations'));

        $this->schema(
            fn (Catagraphy $record) => $record->hasValidVulnerabilities()
                ? $this->getRecommendations($record)
                : $this->getEmptyStateSchema($record)
        );

        $this->footer(''); // Used for padding
    }

    protected function getRecommendations(Catagraphy $catagraphy): array
    {
        $schema = Cache::driver('array')
            ->remember(
                "recommendations-beneficiary-{$catagraphy->beneficiary_id}",
                MINUTE_IN_SECONDS,
                fn () => Recommendation::query()
                    ->with(['services', 'vulnerabilities.category'])
                    ->forVulnerabilities($catagraphy->all_valid_vulnerabilities->pluck('value'))
                    ->limit(5)
                    ->get()
                    ->map(fn (Recommendation $recommendation) => RecommendationCard::make()->model($recommendation))
                    ->all()
            );

        return [
            Grid::make()
                ->schema($schema)
                ->columns([
                    'default' => 1,
                    'md' => 2,
                    'lg' => 1,
                    'xl' => 2,
                    '2xl' => 3,
                ]),
        ];
    }

    protected function getEmptyStateSchema(Catagraphy $catagraphy): array
    {
        return [
            View::make('tables::components.empty-state.index')
                ->viewData([
                    'icon' => 'icon-clipboard',
                    'heading' => __('catagraphy.recommendation.empty.title'),
                    'description' => __('catagraphy.recommendation.empty.description'),
                ]),
        ];
    }
}
