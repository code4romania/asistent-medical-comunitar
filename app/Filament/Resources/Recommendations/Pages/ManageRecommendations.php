<?php

declare(strict_types=1);

namespace App\Filament\Resources\Recommendations\Pages;

use Filament\Actions\CreateAction;
use App\Concerns\HasConditionalTableEmptyState;
use App\Filament\Resources\Recommendations\RecommendationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRecommendations extends ManageRecords
{
    use HasConditionalTableEmptyState;

    protected static string $resource = RecommendationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('recommendation.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('recommendation.empty.description');
    }
}
