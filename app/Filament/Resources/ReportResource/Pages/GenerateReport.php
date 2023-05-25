<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Concerns;
use App\Models\Report;
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

            $data = $this->mutateFormDataBeforeCreate($data);

            $this->callHook('beforeCreate');

            $this->record = Report::make($data);

            $this->form->model($this->record);

            $this->callHook('afterCreate');
        } catch (Halt $exception) {
            return;
        }
    }
}
