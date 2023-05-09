<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\Card;
use App\Models\Intervention\CaseManagement;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewCase extends ViewRecord implements WithSidebar
{
    use Concerns\CommonViewFormSchema;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    public ?CaseManagement $case = null;

    public function getTitle(): string
    {
        return __('case.title', [
            'name' => $this->case->name,
        ]);
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->header(__('case.summary')),
                Card::make()
                    ->header(__('case.services')),
            ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }

    public function beforeFill()
    {
        $this->case = app(CaseManagement::class)
            ->resolveRouteBindingQuery(
                $this->getRecord()->cases(),
                request()->case->id
            )
            ->firstOrFail();
    }
}
