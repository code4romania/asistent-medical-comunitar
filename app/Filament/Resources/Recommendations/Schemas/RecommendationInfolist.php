<?php

declare(strict_types=1);

namespace App\Filament\Resources\Recommendations\Schemas;

use App\Filament\Infolists\Components\ServiceEntry;
use App\Filament\Infolists\Components\VulnerabilityChips;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RecommendationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('description')
                    ->label(__('field.recommendation_description')),

                VulnerabilityChips::make('vulnerabilities')
                    ->label(__('field.recommendation_vulnerabilities')),

                ServiceEntry::make('services.name')
                    ->label(__('field.recommendation_services')),
            ]);
    }
}
