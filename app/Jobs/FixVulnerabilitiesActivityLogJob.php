<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Activity;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class FixVulnerabilitiesActivityLogJob implements ShouldQueue, ShouldBeUnique
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $userId;

    public ?int $fromId;

    public array $ignoreIds;

    public array $upserts = [];

    public array $deletes = [];

    public int $tries = 1;

    public int $uniqueFor = 3600;

    public function uniqueId(): string
    {
        return "fix-vulnerabilities:{$this->userId}";
    }

    /**
     * Create a new job instance.
     */
    public function __construct(int $userId, ?int $fromId = null, array $ignoreIds = [])
    {
        $this->userId = $userId;
        $this->fromId = $fromId;
        $this->ignoreIds = $ignoreIds;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $activities = Activity::query()
            ->withoutGlobalScopes()
            ->withoutEagerLoads()
            ->when($this->fromId, fn (Builder $query) => $query->where('id', '>=', $this->fromId))
            ->when($this->ignoreIds, fn (Builder $query) => $query->whereNotIn('id', $this->ignoreIds))
            ->where('causer_type', 'user')
            ->where('causer_id', $this->userId)
            ->where(
                fn (Builder $query) => $query
                    ->where(
                        fn (Builder $query) => $query
                            ->where('log_name', 'vulnerabilities')
                            ->whereNull('subject_type')
                    )
                    ->orWhere(
                        fn (Builder $query) => $query
                            ->where('log_name', 'catagraphy')
                            ->where('subject_type', 'catagraphy')
                    )
            )
            ->get();

        if ($activities->count() % 3 !== 0) {
            throw new Exception('Invalid number of activities: ' . $activities->count());
        }

        $activities
            ->chunk(3)
            ->each(function (Collection $chunk) {
                $chunk = $chunk->values();

                if ($chunk[0]->log_name !== 'vulnerabilities') {
                    throw new Exception('First entry in chunk is not a vulnerability list: ' . $chunk[0]->id);
                }

                if ($chunk[1]->log_name !== 'vulnerabilities') {
                    throw new Exception('Second entry in chunk is not a vulnerability list: ' . $chunk[1]->id);
                }

                if ($chunk[0]->properties->diff($chunk[1]->properties)->isNotEmpty()) {
                    throw new Exception('Vulnerability lists are not the same: ' . $chunk[0]->id . '|' . $chunk[1]->id);
                }

                if ($chunk[2]->log_name !== 'catagraphy') {
                    throw new Exception('Third entry in chunk is not a catagraphy');
                }

                $this->upserts[] = [
                    'id' => $chunk[1]->id,
                    'created_at' => $chunk[1]->created_at,
                    'description' => $chunk[1]->description,
                    'subject_id' => $chunk[2]->properties['beneficiary_id'],
                    'subject_type' => 'beneficiary',
                ];

                $this->deletes[] = $chunk[0]->id;
            });

        Activity::upsert(
            $this->upserts,
            uniqueBy: ['id'],
            update: ['subject_id', 'subject_type']
        );

        Activity::query()
            ->whereIn('id', $this->deletes)
            ->delete();

        logger()->info('Upserting activities', [
            'user_id' => $this->userId,
        ]);
    }
}
