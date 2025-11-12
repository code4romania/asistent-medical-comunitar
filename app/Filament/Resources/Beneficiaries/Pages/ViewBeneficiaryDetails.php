<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Concerns\DisableNavigationIcon;
use App\Filament\Resources\Beneficiaries\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Concerns\HasRegularBeneficiaryActions;
use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Schemas\RegularBeneficiaryInfolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewBeneficiaryDetails extends ViewRecord
{
    use DisableNavigationIcon;
    use HasBreadcrumbs;
    use HasRegularBeneficiaryActions {
        getHeaderActions as getRegularBeneficiaryActions;
    }
    use UsesParentRecordSubNavigation;

    protected static string $resource = BeneficiaryResource::class;

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
        return __('beneficiary.section.personal_data');
    }

    public function infolist(Schema $schema): Schema
    {
        return RegularBeneficiaryInfolist::configure($schema);
    }
}
