<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

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
            ->where('subject_type', 'beneficiary')
            ->update([
                'activity_log.beneficiary_id' => DB::raw('subject_id'),
            ]);

        $this->info("Updated {$result} activity_log entires for subject_type beneficiary.");

        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->where('subject_type', 'appointment')
            ->join('appointments', 'appointments.id', 'subject_id')
            ->update([
                'activity_log.beneficiary_id' => DB::raw('appointments.beneficiary_id'),
            ]);

        $this->info("Updated {$result} activity_log entires for subject_type appointment.");

        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->where('subject_type', 'document')
            ->join('documents', 'documents.id', 'subject_id')
            ->update([
                'activity_log.beneficiary_id' => DB::raw('documents.beneficiary_id'),
            ]);

        $this->info("Updated {$result} activity_log entires for subject_type document.");

        $result = Activity::query()
            ->whereNull('activity_log.beneficiary_id')
            ->where('subject_type', 'intervention')
            ->join('interventions', 'interventions.id', 'subject_id')
            ->update([
                'activity_log.beneficiary_id' => DB::raw('interventions.beneficiary_id'),
            ]);

        $this->info("Updated {$result} activity_log entires for subject_type intervention.");

        return self::SUCCESS;
    }
}
