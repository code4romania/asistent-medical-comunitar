<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\FixVulnerabilitiesActivityLogJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;

class FixVulnerabilitiesActivityLogCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:activity:fix-vulnerabilities
                            {--from= : The activity ID to start from.}
                            {--ignore= : Comma separated list of activity IDs to ignore.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix missing link between vulnerabilities summary and beneficiary.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $jobs = User::query()
            ->onlyNurses()
            ->whereHas(
                'actions',
                fn (Builder $query) => $query
                    ->where('log_name', 'vulnerabilities')
                    ->whereNull('subject_type')
            )
            ->get()
            ->map(
                fn (User $user) => new FixVulnerabilitiesActivityLogJob(
                    $user->id,
                    $this->option('from'),
                    Str::of($this->option('ignore'))
                        ->explode(',')
                        ->filter()
                        ->all()
                )
            );

        Bus::batch($jobs)
            ->allowFailures()
            ->dispatch();

        $this->info('Successfully dispatched ' . $jobs->count() . ' jobs.');

        return self::SUCCESS;
    }
}
