<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Contracts\Enums\HasQuery;
use App\Enums\Report\Standard\Category;
use App\Enums\Report\Status;
use App\Enums\Report\Type;
use App\Models\Report;
use App\Reports\Queries\ReportQuery;
use BackedEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class GenerateStandardReportJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Delete the job when models are missing.
     *
     * @var bool
     */
    public bool $deleteWhenMissingModels = true;

    public Report $report;

    public ?string $category;

    public Collection $indicators;

    public function uniqueId(): string
    {
        return "generate-report:{$this->report->id}";
    }

    /**
     * Create a new job instance.
     */
    public function __construct(Report $report, array $data)
    {
        $this->report = $report;

        $this->category = data_get($data, 'category');

        $this->indicators = collect(data_get($data, 'indicators'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        rescue(
            function () {
                match ($this->report->type) {
                    Type::LIST => $this->handleList(),
                    Type::STATISTIC => $this->handleStatistic(),
                };

                $this->report->status = Status::FINISHED;
            },
            fn () => ($this->report->status = Status::FAILED),
        );

        $this->report->save();
    }

    protected function handleList(): void
    {
        $this->report->data = $this->report->indicators()
            ->map(function (HasQuery $indicator) {
                /** @var ReportQuery $reportQuery */
                $reportQuery = $indicator->class();

                $columns = collect($reportQuery::columns());

                return [
                    'title' => $indicator->label(),
                    'columns' => $columns
                        ->map(fn (string $label, string $name) => [
                            'name' => $name,
                            'label' => $label,
                        ])
                        ->values(),
                    'data' => $reportQuery::build($this->report)
                        ->get()
                        ->map(
                            fn (Model $record) => $columns
                                ->map(function (string $label, string $name) use ($record) {
                                    $value = $record->{$name};

                                    if ($name === 'date_of_birth') {
                                        $value = $record->age;
                                    }

                                    if ($value instanceof BackedEnum) {
                                        $value = $value->label();
                                    }

                                    return $value;
                                })

                                ->put('actions', $reportQuery::getRecordActions([
                                    'record' => $record,
                                ]))
                        ),
                ];
            });
    }

    protected function handleStatistic(): void
    {
        $this->report->data = [
            [
                'title' => $this->getCategory()->label(),
                'data' => $this->report->indicators()
                    ->mapWithKeys(function (HasQuery $indicator) {
                        /** @var ReportQuery $reportQuery */
                        $reportQuery = $indicator->class();

                        return [
                            $indicator->label() => [$reportQuery::build($this->report)->count()],
                        ];
                    }),
            ],
        ];
    }

    protected function getCategory(): Category
    {
        return Category::from($this->category);
    }
}
