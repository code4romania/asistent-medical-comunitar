<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Activity;
use App\Models\Beneficiary;
use App\Models\Catagraphy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

trait BelongsToCatagraphy
{
    use BelongsToThroughTrait;
    use LogsActivity;

    public function initializeBelongsToCatagraphy(): void
    {
        $this->fillable[] = 'catagraphy_id';
    }

    public function catagraphy(): BelongsTo
    {
        return $this->belongsTo(Catagraphy::class);
    }

    public function beneficiary(): BelongsToThrough
    {
        return $this->belongsToThrough(Beneficiary::class, Catagraphy::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('catagraphy')
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $beneficiary_id = $this->getBeneficiaryIdFrom($activity->subject->catagraphy_id);

        $activity->beneficiary()->associate($beneficiary_id);
    }

    public function getBeneficiaryIdFrom(int $catagraphy_id): ?int
    {
        return Cache::driver('array')
            ->rememberForever(
                "beneficiary-catagraphy-{$catagraphy_id}",
                fn () => Beneficiary::query()
                    ->whereHas('catagraphy', fn ($query) => $query->where('id', $catagraphy_id))
                    ->first()
                    ?->id
            );
    }
}
