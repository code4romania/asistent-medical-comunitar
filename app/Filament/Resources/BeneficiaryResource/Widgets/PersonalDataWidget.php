<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Widgets;

use App\Concerns\Forms\HasComponentActions;
use App\Enums\Beneficiary\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Forms\Components\Badge;
use App\Forms\Components\Value;
use App\Models\Beneficiary;
use Filament\Actions\Action;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Widgets\Widget;

class PersonalDataWidget extends Widget implements HasForms
{
    use EvaluatesClosures;
    use InteractsWithForms;
    use HasComponentActions;

    protected static string $view = 'filament.resources.beneficiary-resource.widgets.personal-data';

    public ?Beneficiary $record = null;

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'xl' => 1,
    ];

    public function __construct($id = null)
    {
        parent::__construct($id);

        $this->headerActions(fn () => [
            Action::make('view')
                ->label(__('beneficiary.action.view_details'))
                ->url(BeneficiaryResource::getUrl('personal_data', $this->record))
                ->color('gray'),
        ]);
    }

    protected function getHeading(): string
    {
        return __('beneficiary.section.personal_data');
    }

    protected function getFormSchema(): array
    {
        return [
            Badge::make('status')
                ->content(fn (Beneficiary $record) => $record->status?->label())
                ->color(fn (Beneficiary $record) => $record->status?->color())
                ->columnSpanFull(),

            Value::make('reason_removed')
                ->label(__('field.reason_removed'))
                ->visible(fn (Beneficiary $record) => $record->status->is(Status::REMOVED))
                ->columnSpanFull(),

            Value::make('id')
                ->label(__('field.beneficiary_id')),

            Value::make('integrated')
                ->label(__('field.integrated'))
                ->boolean(),

            Value::make('household.name')
                ->label(__('field.household')),

            Value::make('family.name')
                ->label(__('field.family')),

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
        ];
    }

    protected function makeForm(): ComponentContainer
    {
        return ComponentContainer::make($this)
            ->columns(2);
    }

    protected function getFormModel(): Beneficiary
    {
        return $this->record;
    }
}
