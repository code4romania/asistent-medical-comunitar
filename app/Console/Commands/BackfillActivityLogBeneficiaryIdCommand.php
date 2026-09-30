<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class BackfillActivityLogBeneficiaryIdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:activity:beneficiary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill beneficiary_id on activity_log based on existing values.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->where('activity_log.subject_type', 'beneficiary')
            ->update([
                'activity_log.beneficiary_id' => DB::raw('subject_id'),
            ]);

        $this->info("Updated {$result} activity_log entires for subject_type beneficiary.");

        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->where('activity_log.subject_type', 'appointment')
            ->join('appointments', 'appointments.id', 'subject_id')
            ->update([
                'activity_log.beneficiary_id' => DB::raw('appointments.beneficiary_id'),
            ]);

        $this->info("Updated {$result} activity_log entires for subject_type appointment.");

        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->where('activity_log.subject_type', 'document')
            ->join('documents', 'documents.id', 'subject_id')
            ->update([
                'activity_log.beneficiary_id' => DB::raw('documents.beneficiary_id'),
            ]);

        $this->info("Updated {$result} activity_log entires for subject_type document.");

        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->where('activity_log.subject_type', 'intervention')
            ->join('interventions', 'interventions.id', 'subject_id')
            ->update([
                'activity_log.beneficiary_id' => DB::raw('interventions.beneficiary_id'),
            ]);

        $this->info("Updated {$result} activity_log entires for subject_type intervention.");

        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->whereIn('activity_log.subject_type', ['document', 'intervention'])
            ->where('activity_log.event', 'created')
            ->update([
                'activity_log.beneficiary_id' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(properties, '$.attributes.beneficiary_id'))"),
            ]);

        $this->info("Updated {$result} `created` activity_log entires for deleted documents and interventions intervention.");

        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->whereIn('activity_log.subject_type', ['document', 'intervention'])
            ->where('activity_log.event', 'deleted')
            ->update([
                'activity_log.beneficiary_id' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(properties, '$.old.beneficiary_id'))"),
            ]);

        $this->info("Updated {$result} `deleted` activity_log entires for deleted documents and interventions intervention.");

        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->whereIn('activity_log.subject_type', ['document', 'intervention'])
            ->where('activity_log.event', 'updated')
            ->join('activity_log as deleted_log', function (JoinClause $join): void {
                $join->on('deleted_log.subject_type', '=', 'activity_log.subject_type')
                    ->on('deleted_log.subject_id', '=', 'activity_log.subject_id')
                    ->where('deleted_log.event', 'deleted');
            })
            ->update([
                'activity_log.beneficiary_id' => DB::raw('deleted_log.beneficiary_id'),
            ]);

        $this->info("Updated {$result} `updated` activity_log entires for deleted documents and interventions intervention.");

        return self::SUCCESS;
    }
}
