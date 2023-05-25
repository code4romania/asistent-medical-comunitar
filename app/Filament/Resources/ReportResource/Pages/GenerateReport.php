<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Concerns;
use App\Models\Report;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;

class GenerateReport extends CreateRecord implements WithTabs
{
    use Concerns\HasTabs;

    protected static string $resource = ReportResource::class;

    protected static string $view = 'filament.resources.report-resource.pages.generate';

    protected static bool $canCreateAnother = false;

    public function mount(): void
    {
        $this->authorizeAccess();

        $this->fillForm();
    }

    public function generate(): void
    {
        $this->authorizeAccess();

        try {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeGenerate($data);

            $this->callHook('beforeGenerate');

            $this->record = Report::create($data);

            $this->form->model($this->record);

            $this->callHook('afterGenerate');
        } catch (Halt $exception) {
            return;
        }
    }

    protected function mutateFormDataBeforeGenerate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label(__('report.action.generate'))
            ->submit('generate')
            ->keyBindings(['mod+s'])
            ->color('warning');
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label(__('report.action.cancel'))
            ->url($this->previousUrl ?? static::getResource()::getUrl())
            ->color('secondary');
    }
}
