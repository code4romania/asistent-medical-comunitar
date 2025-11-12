<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Concerns\DisableNavigationIcon;
use App\Filament\Resources\Beneficiaries\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions\CreateCaseAction;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions\CreateIndividualServiceAction;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use Filament\Panel;
use Filament\Resources\Pages\ManageRelatedRecords;

class ListInterventions extends ManageRelatedRecords
{
    use DisableNavigationIcon;
    use UsesParentRecordSubNavigation;
    use HasBreadcrumbs;

    protected static string $resource = BeneficiaryResource::class;

    protected static string $relationship = 'interventions';

    protected static ?string $relatedResource = InterventionResource::class;

    public function getTitle(): string
    {
        return static::getNavigationLabel();
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public static function getNavigationLabel(): string
    {
        return __('intervention.label.plural');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateIndividualServiceAction::make(),
            CreateCaseAction::make(),
        ];
    }

    public static function getRouteName(?Panel $panel = null): string
    {
        return parent::getRouteName() . '*';
    }
}
