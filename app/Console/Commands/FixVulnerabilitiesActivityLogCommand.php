<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

    protected int $total = 0;

    protected ProgressBar $progressBar;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $nurses = User::query()
            ->onlyNurses();

        $this->progressBar = $this->output->createProgressBar($nurses->count());
        $this->progressBar->setFormat("\n<options=bold>%message%</>\n[%bar%] %current%/%max% nurses\n");
        $this->progressBar->setMessage('Starting to process users...');

        $this->progressBar->start();

        $nurses
            ->with([
                'actions' => fn ($q) => $q
                    ->where(function (Builder $query) {
                        $query
                            ->where('log_name', 'vulnerabilities')
                            ->orWhere(function (Builder $query) {
                                $query->where('log_name', 'catagraphy')
                                    ->whereIn('subject_type', ['disease', 'disability', 'suspicion']);
                            });
                    })
                    ->orderBy('id'),
            ])
            ->chunkById(10, function (Collection $users) {
                foreach ($users as $user) {
                    $currentCreatedAt = null;
                    $relatedActivities = [];
                    $vulnerabilitiesActivity = null;

                    foreach ($user->actions as $activity) {
                        $currentCreatedAt ??= $activity->created_at;

                        if ($activity->created_at->diffInSeconds($currentCreatedAt, true) > 2) {
                            $this->addToBuffer($relatedActivities, $vulnerabilitiesActivity);

                            $this->total++;

                            $currentCreatedAt = $activity->created_at;
                            $relatedActivities = [];
                            $vulnerabilitiesActivity = null;
                        }

                        if ($activity->log_name === 'vulnerabilities') {
                            $vulnerabilitiesActivity = $activity;
                        } else {
                            $relatedActivities[] = $activity;
                        }
                    }

                    $this->progressBar->advance();
                }
            });

        $this->flush();

        $this->progressBar->setMessage("Done. Processed {$this->total} rows.");

        $this->progressBar->finish();

        return self::SUCCESS;
    }

    protected function addToBuffer(array $relatedActivities, ?Activity $vulnerabilitiesActivity): void
    {
        if (blank($relatedActivities) || blank($vulnerabilitiesActivity)) {
            return;
        }

        $vulnIds = collect();

        foreach ($relatedActivities as $relatedActivity) {
            $vulnIds->push(data_get($relatedActivity->properties, 'attributes.type'));

            if ($relatedActivity->subject_type === 'disease') {
                $vulnIds->push(data_get($relatedActivity->properties, 'attributes.category'));
            }

            if ($relatedActivity->subject_type === 'disability') {
                $vulnIds->push(
                    data_get($relatedActivity->properties, 'attributes.has_certificate', false)
                        ? 'VDH_01'
                        : 'VDH_02'
                );

                $vulnIds->push(data_get($relatedActivity->properties, 'attributes.degree'));
            }
        }

        $this->buffer[] = [
            'id' => $vulnerabilitiesActivity->id,
            // 'old' => $vulnerabilitiesActivity->properties->all(),
            'properties' => $vulnIds
                ->concat($vulnerabilitiesActivity->properties)
                ->filter()
                ->unique()
                ->sort()
                ->values()
                ->all(),
        ];

        if (\count($this->buffer) >= (int) $this->option('chunk')) {
            $this->flush();
            $this->progressBar->setMessage("Processed {$this->total} rows...");
        }
    }

    protected function flush(): void
    {
        if (empty($this->buffer)) {
            return;
        }

        $ids = array_column($this->buffer, 'id');

        // Build CASE expression
        $cases = '';
        $bindings = [];

        foreach ($this->buffer as $row) {
            $cases .= ' WHEN ? THEN ?';
            $bindings[] = $row['id'];
            $bindings[] = json_encode($row['properties']);
        }

        $sql = "UPDATE activity_log
                SET properties = CASE id {$cases} END
                WHERE id IN (" . implode(',', array_fill(0, \count($ids), '?')) . ')';

        // Merge id bindings at the end
        $bindings = array_merge(
            $bindings,
            array_column($this->buffer, 'id'), // ids for CASE WHEN ? THEN ?
        );

        if (! $this->option('dry-run')) {
            DB::update($sql, $bindings);
        } else {
            logger()->info('Flushing buffer', $this->buffer);
        }

        $this->buffer = [];
    }
}
