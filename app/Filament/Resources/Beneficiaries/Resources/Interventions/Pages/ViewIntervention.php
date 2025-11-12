<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions\CloseCaseAction;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions\ReopenCaseAction;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\CaseInfolist;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\IndividualServiceInfolist;
use App\Models\Intervention;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewIntervention extends ViewRecord
{
    use HasBreadcrumbs;
    use UsesParentRecordSubNavigation;

    protected static string $resource = InterventionResource::class;

    public function getTitle(): string
    {
        return $this->getRecordTitle();
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label(__('intervention.action.edit'))
                ->color('gray'),

            DeleteAction::make()
                ->label(__('intervention.action.delete'))
                ->successRedirectUrl(BeneficiaryResource::getUrl('interventions', [
                    'record' => $this->getParentRecord(),
                ])),

            // Action::make('export')
            //     ->label(__('intervention.action.export'))
            //     ->icon('heroicon-s-download')
            //     ->color('secondary')
            //     ->disabled(),

            CloseCaseAction::make()
                ->visible(fn (Intervention $record) => $record->isCase() && ! $record->interventionable->is_imported && $record->isOpen()),

            ReopenCaseAction::make()
                ->visible(fn (Intervention $record) => $record->isCase() && ! $record->interventionable->is_imported && ! $record->isOpen()),

        ];
    }

    public function infolist(Schema $schema): Schema
    {
        /** @var Intervention */
        $intervention = $this->getRecord();

        if ($intervention->isCase()) {
            return CaseInfolist::configure($schema);
        }

        return IndividualServiceInfolist::configure($schema);
    }
}
