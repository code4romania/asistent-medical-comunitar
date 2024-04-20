<?php

declare(strict_types=1);

namespace App\Filament\Resources\RecommendationResource\Pages;

use App\Filament\Resources\RecommendationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRecommendations extends ManageRecords
{
    protected static string $resource = RecommendationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getBreadcrumbs(): array
    {
        return [];
    }
}
