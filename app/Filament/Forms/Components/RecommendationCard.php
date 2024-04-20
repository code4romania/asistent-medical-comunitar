<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Filament\Resources\RecommendationResource;
use App\Models\Recommendation;
use Filament\Pages\Actions\Action;

class RecommendationCard extends Card
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->columnSpan(null);

        $this->extraAttributes([
            'class' => 'shadow-lg',
        ]);

        $this->schema(fn (Recommendation $record) => [
            VulnerabilityChips::make('vulnerabilities')
                ->disableLabel(),

            Value::make('title')
                ->extraAttributes(['class' => 'text-lg font-semibold'])
                ->disableLabel(),

            Value::make('description')
                ->extraAttributes(['class' => 'text-gray-500 line-clamp-2'])
                ->disableLabel(),
        ]);

        $this->footerActions(fn (Recommendation $record) => [
            Action::make('view_services')
                ->label(__('recommendation.action.view_services'))
                ->link()
                ->color('primary')
                ->modalHeading($record->title)
                ->form(RecommendationResource::getViewFormSchema()),
        ]);
    }
}
