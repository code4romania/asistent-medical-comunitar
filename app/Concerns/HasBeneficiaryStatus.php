<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\Beneficiary\Status;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

trait HasBeneficiaryStatus
{
    public function initializeHasBeneficiaryStatus(): void
    {
        $this->casts['status'] = Status::class;

        $this->fillable[] = 'status';
    }

    protected static function bootHasBeneficiaryStatus(): void
    {
        static::creating(function (Beneficiary $beneficiary) {
            if ($beneficiary->isRegular() && ! $beneficiary->status) {
                $beneficiary->status = Status::REGISTERED;
            }
        });

        static::updating(function (Beneficiary $beneficiary) {
            if ($beneficiary->isRegular() && $beneficiary->isDirty('type')) {
                $beneficiary->status = Status::REGISTERED;
            }
        });
    }

    public function scopeOnlyActive(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE);
    }

    public function scopeOnlyInactive(Builder $query): Builder
    {
        return $query->where('status', Status::INACTIVE);
    }

    public function changeStatus(Status | string $status): void
    {
        if (\is_string($status)) {
            $status = Status::tryFrom($status);
        }

        $this->update([
            'status' => $status,
        ]);
    }

    public function isRegistered(): bool
    {
        return $this->status->is(Status::REGISTERED);
    }

    public function isCatagraphed(): bool
    {
        return $this->status->is(Status::CATAGRAPHED);
    }

    public function isActive(): bool
    {
        return $this->status->is(Status::ACTIVE);
    }

    public function isInactive(): bool
    {
        return $this->status->is(Status::INACTIVE);
    }

    public function isRemoved(): bool
    {
        return $this->status->is(Status::REMOVED);
    }

    public function markAsRegistered()
    {
        $this->changeStatus(Status::REGISTERED);
    }

    public function markAsCatagraphed()
    {
        $this->changeStatus(Status::CATAGRAPHED);
    }

    public function markAsActive()
    {
        $this->changeStatus(Status::ACTIVE);
    }

    public function markAsInactive()
    {
        $this->changeStatus(Status::INACTIVE);
    }

    public function markAsRemoved()
    {
        $this->changeStatus(Status::REMOVED);
    }
}
