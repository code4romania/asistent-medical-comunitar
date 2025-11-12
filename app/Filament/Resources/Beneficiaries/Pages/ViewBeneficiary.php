<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\Actions\ConvertOcasionalBeneficiaryAction;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Concerns\DisableNavigationIcon;
use App\Filament\Resources\Beneficiaries\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Concerns\HasRegularBeneficiaryActions;
use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Schemas\OcasionalBeneficiaryInfolist;
use App\Filament\Resources\Beneficiaries\Widgets\ActiveInterventionsWidget;
use App\Filament\Resources\Beneficiaries\Widgets\PersonalDataWidget;
use App\Models\Beneficiary;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ViewBeneficiary extends ViewRecord
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
        return $this->getRecordTitle();
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public static function getNavigationLabel(): string
    {
        return 'Overview';
    }

    protected function getHeaderActions(): array
    {
        if ($this->getRecord()->isRegular()) {
            return $this->getRegularBeneficiaryActions();
        }

        return [
            ConvertOcasionalBeneficiaryAction::make(),

            EditAction::make()
                ->icon(Heroicon::Pencil),
        ];
    }

    /**
     * Force an empy infolist for regular beneficiaries.
     */
    protected function hasInfolist(): bool
    {
        return true;
    }

    public function infolist(Schema $schema): Schema
    {
        /** @var Beneficiary */
        $beneficiary = $this->getRecord();

        if ($beneficiary->isRegular()) {
            return $schema;
        }

        $beneficiary->loadMissing('ocasionalInterventions.services');

        return OcasionalBeneficiaryInfolist::configure($schema);
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }

    protected function getHeaderWidgets(): array
    {
        /** @var Beneficiary */
        $beneficiary = $this->getRecord();

        if (! $beneficiary->isRegular()) {
            return [];
        }

        return [
            PersonalDataWidget::class,
            ActiveInterventionsWidget::class,
        ];
    }
}
