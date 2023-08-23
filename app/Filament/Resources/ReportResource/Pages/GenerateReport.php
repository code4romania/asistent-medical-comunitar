<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Actions\SaveReportAction;
use App\Filament\Resources\ReportResource\Concerns;
use App\Models\Report;
use Filament\Pages\Actions\Action;
use Filament\Pages\Contracts\HasFormActions;
use Filament\Resources\Form;
use Filament\Resources\Pages\Concerns\UsesResourceForm;
use Filament\Resources\Pages\Page;
use Filament\Support\Exceptions\Halt;

class GenerateReport extends Page implements HasFormActions, WithTabs
{
    use Concerns\HasTabs;
    use UsesResourceForm;

    public $data;

    public ?Report $record = null;

    protected static string $resource = ReportResource::class;

    protected static string $view = 'filament.resources.report-resource.pages.generate';

    protected static bool $canCreateAnother = false;

    public function mount(): void
    {
        $this->authorizeAccess();

        $this->fillForm();
    }

    protected function authorizeAccess(): void
    {
        static::authorizeResourceAccess();

        abort_unless(static::getResource()::canCreate(), 403);
    }

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $this->form->fill();

        $this->callHook('afterFill');
    }

    public function generate(): void
    {
        $this->authorizeAccess();

        try {
            $data = $this->form->getState();

            $this->record = $this->getModel()::make($data);

            $this->form->model($this->record);

            $this->report->model($this->record);
        } catch (Halt $exception) {
            return;
        }
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->makeForm()
                ->context('generate')
                ->model($this->record)
                ->schema(ReportResource::form(Form::make())->getSchema())
                ->statePath('data'),

            'report' => $this->makeForm()
                ->context('generate')
                ->model($this->record)
                ->schema(ReportResource::report(Form::make())->getSchema())
                ->statePath('data'),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label(__('report.action.generate'))
                ->submit()
                ->keyBindings(['mod+s'])
                ->color('warning'),

            Action::make('cancel')
                ->label(__('report.action.cancel'))
                ->url($this->previousUrl ?? static::getResource()::getUrl())
                ->color('secondary'),

            SaveReportAction::make()
                ->extraAttributes(['class' => 'hidden']),
        ];
    }
}
