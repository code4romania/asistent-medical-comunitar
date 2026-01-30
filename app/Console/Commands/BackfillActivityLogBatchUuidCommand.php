<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function Sentry\logger;

class BackfillActivityLogBatchUuidCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:activity:batch-uuid
                            {--chunk=10000 : Rows per processing chunk}
                            {--dry-run : Do not perform updates}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill batch_uuid on activity_log based on created_at proximity.';

    /**
     * [['id' => ..., 'batch_uuid' => ...], ...].
     *
     * @var array
     */
    protected array $buffer = [];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $chunkSize = (int) $this->option('chunk');

        $query = Activity::query()
            ->whereNull('batch_uuid')
            ->whereIn('log_name', ['catagraphy', 'vulnerabilities'])
            ->orderBy('id')
            ->without('causer', 'subject')
            ->select(['id', 'log_name', 'subject_id', 'created_at']);

        $currentCreatedAt = null;
        $currentSubjectId = null;
        $currentBatchUuid = null;

        $total = 0;

        $query->chunk($chunkSize, function (Collection $rows) use (
            &$currentCreatedAt,
            &$currentSubjectId,
            &$currentBatchUuid,
            $chunkSize,
            &$total
        ): void {
            foreach ($rows as $row) {
                $currentSubjectId ??= $row->subject_id;
                $currentCreatedAt ??= $row->created_at;

                if (
                    $row->subject_id !== $currentSubjectId ||
                    $row->created_at->notEqualTo($currentCreatedAt)
                ) {
                    $currentCreatedAt = $row->created_at;
                    $currentSubjectId = $row->subject_id;
                    $currentBatchUuid = Str::uuid7($currentCreatedAt)->toString();
                }

                $this->buffer[] = [
                    'id' => $row->id,
                    'batch_uuid' => $currentBatchUuid,
                ];

                $total++;

                if (\count($this->buffer) >= $chunkSize) {
                    $this->flush();
                    $this->info("Processed {$total} rows...");
                }
            }
        });

        $this->flush();

        $this->info("Done. Processed {$total} rows.");

        return self::SUCCESS;
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
            $bindings[] = $row['batch_uuid'];
        }

        // $bindings[] = end($ids);
        $sql = "UPDATE activity_log
                SET batch_uuid = CASE id {$cases} END
                WHERE id IN (" . implode(',', array_fill(0, \count($ids), '?')) . ')';

        // Merge id bindings at the end
        $bindings = array_merge(
            $bindings,
            array_column($this->buffer, 'id'), // ids for CASE WHEN ? THEN ?
        );

        if (! $this->option('dry-run')) {
            DB::update($sql, $bindings);
        } else {
            logger()->info('Dry run - would execute SQL:', ['sql' => $sql/*  'bindings' => $bindings */]);
        }

        $this->buffer = [];
    }
}
