<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Intervention;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Console\Helper\ProgressBar;

#[Signature('app:interventions:sync-cases')]
#[Description('Sync the vulnerability_id and secondary_vulnerability_id columns on interventions based on their parent case')]
class SyncCasesVulnerabilitiesCommand extends Command
{
    protected ProgressBar $progressBar;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $cases = Intervention::query()
            ->withoutEagerLoads()
            ->onlyCases()
            ->whereHas(
                'interventions',
                fn (Builder $query): Builder => $query
                    ->whereNull('vulnerability_id')
            )
            ->select([
                'id',
                'vulnerability_id',
                'secondary_vulnerability_id',
                'vulnerability_label',
            ]);

        $this->progressBar = $this->output->createProgressBar($cases->count());
        $this->progressBar->start();

        $cases->each(function (Intervention $case): void {
            $case->interventions()->update([
                'vulnerability_id' => $case->vulnerability_id,
                'secondary_vulnerability_id' => $case->secondary_vulnerability_id,
                'vulnerability_label' => $case->getOriginal('vulnerability_label'),
            ]);

            $this->progressBar->advance();
        });

        $this->progressBar->finish();

        return self::SUCCESS;
    }
}
