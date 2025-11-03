<?php

declare(strict_types=1);

namespace App\Filament\Resources\Recommendations;

use App\Filament\Resources\Recommendations\Pages\ManageRecommendations;
use App\Filament\Resources\Recommendations\Schemas\RecommendationForm;
use App\Filament\Resources\Recommendations\Schemas\RecommendationInfolist;
use App\Filament\Resources\Recommendations\Tables\RecommendationsTable;
use App\Models\Recommendation;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RecommendationResource extends Resource
{
    protected static ?string $model = Recommendation::class;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('vulnerabilities.category');
    }

    public static function form(Schema $schema): Schema
    {
        return RecommendationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RecommendationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecommendationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRecommendations::route('/'),
        ];
    }
}
