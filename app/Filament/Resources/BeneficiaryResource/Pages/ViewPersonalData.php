<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\BeneficiaryProgram;
use App\Forms\Components\Card;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewPersonalData extends ViewRecord implements WithSidebar
{
    use Concerns\CommonViewFormSchema;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    public function getTitle(): string
    {
        return __('beneficiary.section.personal_data');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                BeneficiaryProgram::make(),

                Card::make()
                    ->header(__('beneficiary.header.id'))
                    ->footer(fn () => EditAction::make())
                    ->schema(static::getRegularBeneficiaryFormSchema()),
            ]);
    }
}
