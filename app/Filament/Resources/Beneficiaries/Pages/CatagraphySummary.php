<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\HasActions;
use App\Filament\Resources\Beneficiaries\Concerns\HasRecordBreadcrumb;
use App\Filament\Resources\Beneficiaries\Concerns\HasSidebar;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\Action;
use App\Concerns\InteractsWithCatagraphy;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\RecommendationsSection;
use App\Forms\Components\VulnerabilityChips;
use App\Models\Catagraphy;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View as ViewContract;

class CatagraphySummary extends ViewRecord implements WithSidebar
{
    use HasActions;
    use HasRecordBreadcrumb;
    use HasSidebar;
    use InteractsWithCatagraphy;

    protected static string $resource = BeneficiaryResource::class;

    public function getTitle(): string
    {
        return __('beneficiary.section.catagraphy');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public function mount(int | string $record): void
    {
        static::authorizeResourceAccess();

        $this->resolveBeneficiary($record);

        $this->record = $this->beneficiary->catagraphy;

        abort_unless(BeneficiaryResource::canView($this->getRecord()), 403);

        abort_unless($this->getBeneficiary()->isRegular(), 404);

        $this->fillForm();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->heading(__('catagraphy.header.vulnerabilities'))
                    ->headerActions([
                        Action::make('view')
                            ->label(__('catagraphy.action.view'))
                            ->visible(fn (Catagraphy $record) => filled($record->created_at))
                            ->url(BeneficiaryResource::getUrl('catagraphy.view', [
                                'record' => $this->getBeneficiary(),
                            ]))
                            ->color('gray'),
                    ])
                    // ->footer($this->getVulnerabilitiesFooter())
                    ->schema($this->getVulnerabilitiesFormSchema()),

                RecommendationsSection::make(),
            ]);
    }

    protected function getVulnerabilitiesFormSchema(): array
    {
        if (! $this->getRecord()->created_at) {
            return [
                \Filament\Schemas\Components\View::make('tables::components.empty-state.index')
                    ->viewData([
                        'icon' => 'icon-empty-state',
                        'heading' => __('catagraphy.vulnerability.empty.title'),
                        'description' => __('catagraphy.vulnerability.empty.description'),
                        'actions' => [
                            Action::make('create')
                                ->label(__('catagraphy.vulnerability.empty.create'))
                                ->url(BeneficiaryResource::getUrl('catagraphy.edit', ['record' => $this->getBeneficiary()]))
                                ->button()
                                ->color('gray'),
                        ],
                    ]),
            ];
        }

        return [
            VulnerabilityChips::make('socioeconomic_vulnerabilities')
                ->label(__('catagraphy.vulnerability.socioeconomic')),

            VulnerabilityChips::make('health_vulnerabilities')
                ->label(__('catagraphy.vulnerability.health')),

            VulnerabilityChips::make('reproductive_health')
                ->label(__('catagraphy.vulnerability.reproductive_health')),

            VulnerabilityChips::make('suspicions')
                ->label(__('catagraphy.vulnerability.suspicions')),
        ];
    }

    protected function getVulnerabilitiesFooter(): ?ViewContract
    {
        /** @var Catagraphy */
        $catagraphy = $this->getRecord();

        if (! $catagraphy->created_at) {
            return null;
        }

        return view('catagraphy.last_updated', [
            'created_at' => $catagraphy->created_at->toFormattedDateTime(),
            'updated_at' => $catagraphy->updated_at->toFormattedDateTime(),
            'name' => $catagraphy->nurse->full_name,
            'history_url' => BeneficiaryResource::getUrl('history', [
                'record' => $this->getBeneficiary(),
            ]),
        ]);
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
