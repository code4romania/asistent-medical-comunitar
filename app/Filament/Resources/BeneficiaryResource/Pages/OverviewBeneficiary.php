<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Enums\Beneficiary\Type;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\Badge;
use App\Forms\Components\Card;
use App\Forms\Components\Household;
use App\Forms\Components\Value;
use App\Models\Beneficiary;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class OverviewBeneficiary extends ViewRecord implements WithSidebar
{
    use Concerns\CommonViewFormSchema;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('convert')
                ->visible(fn () => $this->record->isOcasional())
                ->action(fn () => $this->record->convertToRegular())
                ->label(__('beneficiary.action_convert.action'))
                ->modalHeading(__('beneficiary.action_convert_confirm.title'))
                ->modalSubheading(__('beneficiary.action_convert_confirm.text'))
                ->modalButton(__('beneficiary.action_convert_confirm.action'))
                ->modalWidth('md')
                ->centerModal(false)
                ->color('secondary'),

            Actions\EditAction::make()
                ->icon('heroicon-s-pencil'),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name ?? __('field.has_unknown_identity');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function form(Form $form): Form
    {
        return match ($this->getRecord()->type) {
            Type::REGULAR => static::getRegularBeneficiaryForm($form),
            Type::OCASIONAL => static::getOcasionalBeneficiaryForm($form),
        };
    }

    protected static function getRegularBeneficiaryForm(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Card::make()
                    ->header(__('beneficiary.section.personal_data'))
                    ->columns(2)
                    ->columnSpan([
                        'xl' => 1,
                    ])
                    ->schema([
                        Badge::make('status')
                            ->content(fn (Beneficiary $record) => $record->status?->label())
                            ->color(fn (Beneficiary $record) => $record->status?->color())
                            ->columnSpanFull(),

                        Value::make('reason_removed')
                            ->label(__('field.reason_removed'))
                            ->columnSpanFull(),

                        Value::make('id')
                            ->label(__('field.beneficiary_id')),

                        Value::make('integrated')
                            ->label(__('field.integrated')),

                        Household::make()
                            ->withoutSubsection()
                            ->columns(2)
                            ->columnSpanFull(),

                        Value::make('age')
                            ->label(__('field.age')),

                        Value::make('gender')
                            ->label(__('field.gender')),

                        Value::make('full_address')
                            ->label(__('field.address'))
                            ->columnSpanFull(),

                        Value::make('phone')
                            ->label(__('field.phone'))
                            ->columnSpanFull(),

                    ]),

                Card::make()
                    ->header(__('beneficiary.section.active_interventions'))
                    ->columnSpan([
                        'xl' => 2,
                    ])
                    ->schema([
                        // TODO: figure out interventions list
                    ]),
            ]);
    }

    protected static function getOcasionalBeneficiaryForm(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->header(__('beneficiary.section.personal_data'))
                    ->schema(static::getOcasionalBeneficiaryFormSchema()),
            ]);
    }
}
