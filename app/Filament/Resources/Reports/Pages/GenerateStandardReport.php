<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reports\Pages;

use App\Contracts\Enums\HasQuery;
use App\Enums\Report\Type;
use App\Filament\Resources\Reports\ReportResource;
use App\Filament\Resources\Reports\Widgets\ReportsTableWidget;
use App\Jobs\GenerateReport\Standard;
use App\Models\Report;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GenerateStandardReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        return ucfirst(__('report.label.plural'));
    }

    public function getBreadcrumbs(): array
    {
        return [
            //
        ];
    }

    /**
     * Disable form actions (submit, cancel) as they are handled in the form schema.
     */
    protected function getFormActions(): array
    {
        return [
            //
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            ReportsTableWidget::class,
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $dateRange = Str::of($data['date'])
            ->explode(' - ')
            ->map(fn (string $date): string => Carbon::parse($date)->toDateString())
            ->toArray();

        $data['date_from'] = $dateRange[0];
        $data['date_until'] = $dateRange[1];

        unset($data['date']);

        $category = data_get($data, 'category');

        $data['indicators'] = collect($data['indicators'])
            ->map(fn (string $indicator) => $category->indicator()::from($indicator))
            ->reject(fn (?HasQuery $indicator) => blank($indicator) || ! class_exists($indicator->class()))
            ->mapWithKeys(fn (HasQuery $indicator) => [
                $indicator->value => $indicator->getLabel(),
            ])
            ->toArray();

        return $data;
    }

    protected function handleRecordCreation(array $data): Report
    {
        $record = parent::handleRecordCreation($data);

        $this->dispatchJob($record, $data);

        return $record;
    }

    protected function dispatchJob(Report $record, array $data): void
    {
        if (auth()->user()->isNurse()) {
            $job = match ($record->type) {
                Type::LIST => Standard\Nurse\GenerateListReportJob::class,
                Type::STATISTIC => Standard\Nurse\GenerateStatisticReportJob::class,
            };
        }

        if (auth()->user()->isCoordinator()) {
            $job = Standard\Coordinator\GenerateStatisticReportJob::class;
        }

        if (auth()->user()->isAdmin()) {
            $job = Standard\Admin\GenerateStatisticReportJob::class;
        }

        $job::dispatch($record, $data);
    }
}
