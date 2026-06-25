<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToMediator
{
    public function initializeBelongsToMediator(): void
    {
        $this->fillable[] = 'mediator_id';
    }

    public function bootBelongsToMediator(): void
    {
        static::creating(function (self $model): void {
            if (auth()->user()?->isNurse()) {
                $model->mediator_id = auth()->id();
            }
        });
    }

    public function mediator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mediator_id')->onlyMediators();
    }
}
