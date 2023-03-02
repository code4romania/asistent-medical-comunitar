<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\Card;
use App\Models\Beneficiary;
use App\Models\Catagraphy;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\View;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View as ViewContract;

class CatagraphySummary extends ViewRecord implements WithSidebar
{
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name;
    }

    public function getBreadcrumb(): string
    {
        return __('catagraphy.label.singular');
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->header(__('catagraphy.header.vulnerabilities'))
                    ->footer($this->getVulnerabilitiesFooter())
                    ->schema($this->getVulnerabilitiesFormSchema()),

                Card::make()
                    ->header(__('catagraphy.header.recommendations'))
                    ->schema([
                        View::make('vendor.tables.components.empty-state.index')
                            ->viewData([
                                'icon' => 'icon-clipboard',
                                'heading' => __('catagraphy.recommendation.empty.title'),
                                'description' => __('catagraphy.recommendation.empty.description'),
                            ]),
                    ]),
            ]);
    }

    protected function getVulnerabilitiesFormSchema(): array
    {
        /** @var Beneficiary */
        $beneficiary = $this->getRecord();

        if (! $beneficiary->catagraphy->created_at) {
            return [
                View::make('vendor.tables.components.empty-state.index')
                    ->viewData([
                        'icon' => 'icon-empty-state',
                        'heading' => __('catagraphy.vulnerability.empty.title'),
                        'description' => __('catagraphy.vulnerability.empty.description'),
                        'actions' => [
                            Action::make('create')
                                ->label(__('catagraphy.vulnerability.empty.create'))
                                ->url(static::getResource()::getUrl('catagraphy.edit', ['record' => $this->getRecord()]))
                                ->button()
                                ->color('secondary'),
                        ],
                    ]),
            ];
        }

        return [
            Group::make(),
        ];
    }

    protected function getVulnerabilitiesFooter(): ?ViewContract
    {
        /** @var Catagraphy */
        $catagraphy = $this->getRecord()->catagraphy;

        if (! $catagraphy->created_at) {
            return null;
        }

        return view('catagraphy.last_updated', [
            'catagraphy' => $catagraphy,
        ]);
    }
}
