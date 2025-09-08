<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Pages;

use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\CatagraphyResource;
use App\Filament\Resources\CatagraphyResource\Concerns;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Forms\Components\VulnerabilityChips;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewCatagraphy extends ViewRecord
{
    use Concerns\ResolvesRecord;
    use Concerns\HasRecordBreadcrumb;

    protected static string $resource = CatagraphyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->url(BeneficiaryResource::getUrl('catagraphy.edit', [
                    'record' => $this->getBeneficiary(),
                ])),
        ];
    }

    public function getTitle(): string
    {
        return __('catagraphy.form.view');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        abort_unless($this->getBeneficiary()->isRegular(), 404);
        abort_unless($this->getRecord()->created_at, 404);
    }

    public function form(Form $form): Form
    {
        $categories = VulnerabilityCategory::cachedList();

        return $form
            ->columns(1)
            ->schema([
                Section::make()
                    ->schema([
                        Subsection::make()
                            ->title(__('catagraphy.section.general'))
                            ->icon('heroicon-o-information-circle')
                            ->columns(2)
                            ->schema([
                                Value::make('evaluation_date')
                                    ->label(__('field.evaluation_date')),

                                VulnerabilityChips::make('cat_soc')
                                    ->label($categories->get('SOC'))
                                    ->columnSpanFull(),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.socioeconomic'))
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->columns(2)
                            ->schema([
                                VulnerabilityChips::make('cat_id')
                                    ->label($categories->get('ID')),

                                VulnerabilityChips::make('cat_age')
                                    ->label($categories->get('AGE')),

                                VulnerabilityChips::make('cat_inc')
                                    ->label($categories->get('INC')),

                                VulnerabilityChips::make('cat_pov')
                                    ->label($categories->get('POV')),

                                VulnerabilityChips::make('cat_liv')
                                    ->label($categories->get('LIV')),

                                VulnerabilityChips::make('cat_fam')
                                    ->label($categories->get('FAM')),

                                VulnerabilityChips::make('cat_edu')
                                    ->label($categories->get('EDU')),

                                VulnerabilityChips::make('cat_vif')
                                    ->label($categories->get('VIF')),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([
                                VulnerabilityChips::make('cat_as')
                                    ->label($categories->get('AS')),

                                VulnerabilityChips::make('cat_mf')
                                    ->label($categories->get('MF')),

                                VulnerabilityChips::make('cat_diz')
                                    ->label($categories->get('DIZ'))
                                    ->columnSpanFull(),

                                VulnerabilityChips::make('cat_cr')
                                    ->label($categories->get('CR')),

                                VulnerabilityChips::make('cat_ns')
                                    ->label($categories->get('NS')),

                                VulnerabilityChips::make('cat_ssa')
                                    ->label($categories->get('SSA')),

                                VulnerabilityChips::make('cat_ss')
                                    ->label($categories->get('SS')),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.reproductive_health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([
                                VulnerabilityChips::make('cat_rep')
                                    ->label($categories->get('REP')),

                                VulnerabilityChips::make('cat_preg')
                                    ->label($categories->get('PREG'))
                                    ->visible(fn (callable $get) => Vulnerability::isPregnancy($get('cat_rep'))),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.section.suspicions'))
                            ->icon('heroicon-o-question-mark-circle')
                            ->schema([
                                VulnerabilityChips::make('suspicions')
                                    ->label($categories->get('SUS_CS')),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.section.notes'))
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                Value::make('notes')
                                    ->disableLabel()
                                    ->extraAttributes(['class' => 'prose max-w-none']),
                            ]),
                    ]),

            ]);
    }
}
