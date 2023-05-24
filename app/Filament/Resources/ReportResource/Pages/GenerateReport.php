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

    public function create(bool $another = false): void
    {
        $this->authorizeAccess();

        try {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeCreate($data);

            $this->callHook('beforeCreate');

            $this->record = $this->handleRecordCreation($data);

            // $this->form->model($this->record)->saveRelationships();

            $this->callHook('afterCreate');
        } catch (Halt $exception) {
            return;
        }

        // $this->getCreatedNotification()?->send();

        // if ($another) {
        //     // Ensure that the form record is anonymized so that relationships aren't loaded.
        //     $this->form->model($this->record::class);
        //     $this->record = null;

        //     $this->fillForm();

        //     return;
        // }

        // $this->redirect($this->getRedirectUrl());
    }

    protected function handleRecordCreation(array $data): Report
    {
        return Report::make($data);
    }
}
