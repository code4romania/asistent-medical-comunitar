<?php

declare(strict_types=1);

use App\Imports\VulnerabilitiesImport;
use App\Models\Activity;
use App\Models\Catagraphy;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Excel::import(new VulnerabilitiesImport, database_path('data/241028-vulnerabilities.xlsx'));

        $cutoffDate = Carbon::parse('2024-10-24 00:00:00');

        $callback = fn (string $preg) => $preg === 'VGR_98' ? 'VGR_96' : $preg;

        // Catagraphy
        // updated_at >= 2024-10-24 00:00:00
        // cat_preg VGR_98 => VGR_96
        Catagraphy::query()
            ->whereDate('updated_at', '>=', $cutoffDate)
            ->whereJsonContains('cat_preg', 'VGR_98')
            ->get()
            ->each(function (Catagraphy $catagraphy) use ($callback) {
                $catagraphy->timestamps = false;

                $catagraphy->updateQuietly([
                    'cat_preg' => collect($catagraphy->cat_preg)
                        ->map($callback)
                        ->all(),
                ]);
            });

        // Activity log `vulnerabilities`
        // created_at >= 2024-10-24 00:00:00
        // VGR_98 => VGR_96
        Activity::query()
            ->where('created_at', '>=', $cutoffDate)
            ->where('log_name', 'vulnerabilities')
            ->whereJsonContains('properties', 'VGR_98')
            ->get()
            ->each(function (Activity $activity) use ($callback) {
                $activity->timestamps = false;

                $activity->updateQuietly([
                    'properties' => $activity->properties
                        ->map($callback)
                        ->all(),
                ]);
            });
    }
};
