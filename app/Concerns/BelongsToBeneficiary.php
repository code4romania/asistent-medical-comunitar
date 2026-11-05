<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Activity;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToBeneficiary
{
    public function initializeBelongsToBeneficiary(): void
    {
        $this->fillable[] = 'beneficiary_id';
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function scopeWhereBeneficiary(Builder $query, Beneficiary $beneficiary, string $prefix = ''): Builder
    {
        return $query->where(
            collect([$prefix, 'beneficiary_id'])
                ->filter()
                ->implode('.'),
            $beneficiary->id
        );
    }

    public function tapActivity(Activity $activity, string $eventName): void
    {
        /** @var Beneficiary */
        $beneficiary = $activity->subject->beneficiary;

        $activity->beneficiary()->associate($beneficiary);
    }
}
