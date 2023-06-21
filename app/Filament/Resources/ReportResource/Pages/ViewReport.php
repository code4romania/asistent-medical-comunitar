<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Concerns;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord implements WithTabs
{
    use Concerns\HasTabs;

    protected static string $resource = ReportResource::class;

    protected static string $view = 'filament.resources.report-resource.pages.view';

    protected function getActions(): array
    {
        return [];
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->makeForm()
                ->context('view')
                ->disabled()
                ->model($this->getRecord())
                ->schema(ReportResource::form(Form::make())->getSchema())
                ->statePath('data'),

            'report' => $this->makeForm()
                ->context('view')
                ->disabled()
                ->model($this->getRecord())
                ->schema(ReportResource::report(Form::make())->getSchema())
                ->statePath('data'),
        ];
    }
}
