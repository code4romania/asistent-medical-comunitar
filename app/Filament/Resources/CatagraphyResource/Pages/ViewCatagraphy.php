<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Pages;

use App\Enums\Suspicion\Category;
use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\Repeater;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Filament\Forms\Components\VulnerabilityChips;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\CatagraphyResource;
use App\Filament\Resources\CatagraphyResource\Concerns;
use App\Models\Vulnerability\Vulnerability;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewCatagraphy extends ViewRecord
{
    use Concerns\ResolvesRecord;
    use Concerns\HasRecordBreadcrumb;

    protected static string $resource = CatagraphyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()
                ->url(BeneficiaryResource::getUrl('catagraphy.edit', $this->getBeneficiary())),
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

    public function mount($record): void
    {
        parent::mount($record);

        abort_unless($this->getBeneficiary()->isRegular(), 404);
        abort_unless($this->getRecord()->created_at, 404);
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->schema([
                        Subsection::make()
                            ->title(__('catagraphy.section.general'))
                            ->icon('heroicon-o-information-circle')
                            ->columns(2)
                            ->schema([
                                Value::make('evaluation_date')
                                    ->label(__('field.evaluation_date')),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.socioeconomic'))
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->columns(2)
                            ->schema([
                                VulnerabilityChips::make('cat_id')
                                    ->label(__('vulnerability.field.cat_id')),

                                VulnerabilityChips::make('cat_age')
                                    ->label(__('vulnerability.field.cat_age')),

                                VulnerabilityChips::make('cat_inc')
                                    ->label(__('vulnerability.field.cat_inc')),

                                VulnerabilityChips::make('cat_pov')
                                    ->label(__('vulnerability.field.cat_pov')),

                                VulnerabilityChips::make('cat_liv')
                                    ->label(__('vulnerability.field.cat_liv')),

                                VulnerabilityChips::make('cat_fam')
                                    ->label(__('vulnerability.field.cat_fam')),

                                VulnerabilityChips::make('cat_edu')
                                    ->label(__('vulnerability.field.cat_edu')),

                                VulnerabilityChips::make('cat_vif')
                                    ->label(__('vulnerability.field.cat_vif')),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([
                                VulnerabilityChips::make('cat_as')
                                    ->label(__('vulnerability.field.cat_as')),

                                VulnerabilityChips::make('cat_mf')
                                    ->label(__('vulnerability.field.cat_mf')),

                                VulnerabilityChips::make('cat_diz')
                                    ->label(__('vulnerability.field.cat_diz'))
                                    ->columnSpanFull(),

                                VulnerabilityChips::make('cat_cr')
                                    ->label(__('vulnerability.field.cat_cr')),

                                VulnerabilityChips::make('cat_ns')
                                    ->label(__('vulnerability.field.cat_ns')),

                                VulnerabilityChips::make('cat_ssa')
                                    ->label(__('vulnerability.field.cat_ssa')),

                                VulnerabilityChips::make('cat_ss')
                                    ->label(__('vulnerability.field.cat_ss')),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.reproductive_health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([
                                VulnerabilityChips::make('cat_rep')
                                    ->label(__('vulnerability.field.cat_rep')),

                                VulnerabilityChips::make('cat_preg')
                                    ->label(__('vulnerability.field.cat_preg'))
                                    ->visible(fn (callable $get) => Vulnerability::isPregnancy($get('cat_rep'))),
                            ]),

                        Repeater::make('suspicions')
                            ->relationship()
                            ->label(__('catagraphy.section.suspicions'))
                            ->schema([
                                Subsection::make()
                                    ->icon('heroicon-o-question-mark-circle')
                                    ->columns()
                                    ->schema([
                                        Value::make('name')
                                            ->label(__('field.suspicion_name')),

                                        Value::make('category')
                                            ->label(__('field.suspicion_category')),

                                        Value::make('elements')
                                            ->label(__('field.suspicion_elements'))
                                            ->visible(fn (Closure $get) => $get('category') === 'VSP_01'),

                                        Value::make('notes')
                                            ->label(__('field.suspicion_notes')),
                                    ]),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.section.notes'))
                            ->icon('heroicon-o-annotation')
                            ->schema([
                                Value::make('notes')
                                    ->disableLabel()
                                    ->extraAttributes(['class' => 'prose max-w-none']),
                            ]),
                    ]),

            ]);
    }
}
