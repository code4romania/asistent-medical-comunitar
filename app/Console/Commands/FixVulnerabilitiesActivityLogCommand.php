<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\ConsolidatePreviousVulnerabilitiesJob;
use App\Models\Beneficiary;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Bus;
use Symfony\Component\Console\Helper\ProgressBar;

class FixVulnerabilitiesActivityLogCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:activity:fix-vulnerabilities
                            {--chunk=1000 : Rows per processing chunk}
                            {--dry-run : Do not perform updates}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix ';

    /**
     * [['id' => ..., 'properties' => ...], ...].
     *
     * @var array
     */
    protected array $buffer = [];

    protected ProgressBar $progressBar;

    protected array $beneficiaries = [];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $beneficiaries = Beneficiary::query();

        $this->progressBar = $this->output->createProgressBar($beneficiaries->count());
        $this->progressBar->start();

        $jobs = [];

        $beneficiaries
            ->select('id')
            ->chunkById(1000, function ($beneficiaries) use (&$jobs) {
                $jobs[] = new ConsolidatePreviousVulnerabilitiesJob($beneficiaries->pluck('id')->all());
                // alternative to ConsolidatePreviousVulnerabilitiesJob::dispatch($beneficiaries->pluck('id')->all());

                $this->progressBar->advance(1000);
            });

        Bus::batch($jobs)
            ->allowFailures()
            ->dispatch();

        $this->progressBar->finish();

        return self::SUCCESS;
    }
}
