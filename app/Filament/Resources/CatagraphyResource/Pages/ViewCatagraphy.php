<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Pages;

use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\CatagraphyResource;
use App\Filament\Resources\CatagraphyResource\Concerns;
use App\Forms\Components\Card;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Forms\Components\VulnerabilityChips;
use App\Models\Catagraphy;
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
                                    ->content(fn (Catagraphy $record) => $record->updated_at),

                                Value::make('nurse')
                                    ->content(fn (Catagraphy $record) => $record->nurse->full_name),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.socioeconomic'))
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->columns(2)
                            ->schema([
                                VulnerabilityChips::make('id_type')
                                    ->label(__('field.id_type')),

                                VulnerabilityChips::make('age_category')
                                    ->label(__('field.age_category')),

                                VulnerabilityChips::make('income')
                                    ->label(__('field.income')),

                                VulnerabilityChips::make('poverty')
                                    ->label(__('field.poverty')),

                                VulnerabilityChips::make('habitation')
                                    ->label(__('field.habitation')),

                                VulnerabilityChips::make('family')
                                    ->label(__('field.family')),

                                VulnerabilityChips::make('education')
                                    ->label(__('field.education')),

                                VulnerabilityChips::make('domestic_violence')
                                    ->label(__('field.domestic_violence')),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([
                                VulnerabilityChips::make('social_health_insurance')
                                    ->label(__('field.social_health_insurance')),

                                VulnerabilityChips::make('family_doctor')
                                    ->label(__('field.family_doctor')),

                                VulnerabilityChips::make('disability')
                                    ->label(__('field.disability')),

                                VulnerabilityChips::make('risk_behavior')
                                    ->label(__('field.risk_behavior')),

                                VulnerabilityChips::make('health_need')
                                    ->label(__('field.health_need')),

                                VulnerabilityChips::make('children_health_risk')
                                    ->label(__('field.children_health_risk')),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.reproductive_health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([]),

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
