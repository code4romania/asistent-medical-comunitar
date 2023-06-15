<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Forms\Components\BeneficiaryProgram;
use App\Filament\Forms\Components\Card;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewPersonalData extends ViewRecord implements WithSidebar
{
    use Concerns\CommonViewFormSchema;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    public function mount($record): void
    {
        parent::mount($record);

        $this->resolveBeneficiary($record);
    }

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
                    ->componentActions(fn ($record) => [
                        Actions\Action::make('view')
                            ->label(__('filament-support::actions/edit.single.label'))
                            ->icon('heroicon-s-pencil')
                            ->url(static::getResource()::getUrl('edit', $record)),
                    ])
                    ->schema(static::getRegularBeneficiaryFormSchema()),
            ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
