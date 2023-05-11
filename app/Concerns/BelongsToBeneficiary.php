<?php

declare(strict_types=1);

namespace App\Concerns;

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

    public function scopeWhereBeneficiary(Builder $query, Beneficiary $beneficiary): Builder
    {
        return $query->where('beneficiary_id', $beneficiary->id);
    }
}
