<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Table;

class ListInterventions extends ManageRelatedRecords
{
    protected static string $resource = BeneficiaryResource::class;

    protected static string $relationship = 'interventions';

    protected static ?string $relatedResource = InterventionResource::class;

    public function getTitle(): string
    {
        return __('intervention.label.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('intervention.label.plural');
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
