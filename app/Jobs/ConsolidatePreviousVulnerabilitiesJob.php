<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Activity;
use App\Models\Beneficiary;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ConsolidatePreviousVulnerabilitiesJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public array $beneficiaries;

    /**
     * [['id' => ..., 'properties' => ...], ...].
     *
     * @var array
     */
    protected array $buffer = [];

    /**
     * Create a new job instance.
     */
    public function __construct(array $beneficiaries)
    {
        $this->beneficiaries = $beneficiaries;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Beneficiary::query()
            ->whereIn('id', $this->beneficiaries)
            ->with([
                'relatedActivities' => fn (HasMany $query) => $query
                    ->withoutGlobalScope('latest')
                    ->withoutEagerLoads()
                    ->where(function (Builder $query) {
                        $query
                            ->where('log_name', 'vulnerabilities')
                            ->orWhere(function (Builder $query) {
                                $query->where('log_name', 'catagraphy')
                                    ->whereIn('subject_type', ['disease', 'disability', 'suspicion']);
                            });
                    }),
            ])
            ->lazy()
            ->each(function (Beneficiary $beneficiary) {
                $currentCreatedAt = null;
                $relatedActivities = [];
                $vulnerabilitiesActivity = null;
                $previousVulnerabilitiesDiff = [];

                foreach ($beneficiary->relatedActivities as $activity) {
                    $currentCreatedAt ??= $activity->created_at;

                    if ($activity->created_at->diffInSeconds($currentCreatedAt, true) > 2) {
                        if (filled($relatedActivities) && filled($vulnerabilitiesActivity)) {
                            $previousVulnerabilitiesDiff = $this->addToBuffer(
                                $relatedActivities,
                                $vulnerabilitiesActivity,
                                $previousVulnerabilitiesDiff,
                            );
                        }

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
            });

        $this->flush();
    }

    protected function addToBuffer(array $relatedActivities, ?Activity $vulnerabilitiesActivity, array $previousVulnerabilitiesDiff): array
    {
        $vulnIds = collect();

        foreach ($relatedActivities as $relatedActivity) {
            $vulnIds->push(data_get($relatedActivity->properties, 'attributes.type'));

            if ($relatedActivity->subject_type === 'disease') {
                $vulnIds->push(data_get($relatedActivity->properties, 'attributes.category'));
                $vulnIds->push(data_get($relatedActivity->properties, 'attributes.rare_disease'));
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
            'properties' => $vulnIds
                ->concat($previousVulnerabilitiesDiff)
                ->concat($vulnerabilitiesActivity->properties)
                ->filter()
                ->unique()
                ->sort()
                ->values()
                ->all(),
        ];

        return $vulnIds->all();
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

        DB::update($sql, $bindings);

        $this->buffer = [];
    }
}
