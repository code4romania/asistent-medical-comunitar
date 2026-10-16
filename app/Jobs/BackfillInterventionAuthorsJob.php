<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;

class BackfillInterventionAuthorsJob implements ShouldQueue
{
    use Batchable;
    use Queueable;

    public array $range;

    public function __construct(int $fromId, int $toId)
    {
        $this->range = [$fromId, $toId];
    }

    public function handle(): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        DB::table('interventions')
            ->whereNull('interventions.user_id')
            ->whereBetween('interventions.id', $this->range)
            ->join('beneficiaries', 'beneficiaries.id', 'interventions.beneficiary_id')
            ->leftJoin('activity_log', fn (JoinClause $join): JoinClause => $join
                ->on('activity_log.subject_id', 'interventions.id')
                ->where('activity_log.subject_type', 'intervention')
                ->where('activity_log.event', 'created')
                ->where('activity_log.causer_type', 'user'))
            ->update([
                'interventions.user_id' => new Coalesce(['activity_log.causer_id', 'beneficiaries.mediator_id', 'beneficiaries.nurse_id']),
            ]);
    }
}
