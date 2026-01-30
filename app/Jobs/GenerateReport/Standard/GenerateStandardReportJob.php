<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard;

use App\Enums\Report\Standard\Category;
use App\Enums\Report\Status;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

abstract class GenerateStandardReportJob implements ShouldQueue, ShouldBeUnique
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

    public Category $category;

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

    abstract public function generate(): void;

    public function handle(): void
    {
        rescue(function () {
            $this->generate();

            $this->report->status = Status::FINISHED;
        }, function () {
            $this->report->status = Status::FAILED;
        });

        $this->report->save();
    }
}
