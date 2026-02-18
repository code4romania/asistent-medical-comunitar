<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;
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
    protected $description = 'Backfill beneficiary_id on activity_log based on properties->beneficiary_id';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Activity::query()
            ->whereNull('beneficiary_id')
            ->where('subject_type', 'beneficiary')
            ->update([
                'beneficiary_id' => DB::raw('subject_id'),
            ]);

        Activity::query()
            ->whereNull('beneficiary_id')
            ->whereNot('subject_type', 'beneficiary')
            ->update([
                'beneficiary_id' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(properties, '$.beneficiary_id'))"),
            ]);

        Activity::query()
            ->whereNotNull('beneficiary_id')
            ->whereNotNull('properties')
            ->update([
                'properties' => DB::raw("JSON_REMOVE(properties, '$.beneficiary_id')"),
            ]);

        return self::SUCCESS;
    }
}
