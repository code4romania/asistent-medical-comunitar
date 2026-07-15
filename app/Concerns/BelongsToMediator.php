<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToMediator
{
    public function initializeBelongsToMediator(): void
    {
        $this->fillable[] = 'mediator_id';
    }

    public static function bootBelongsToMediator(): void
    {
        static::creating(function (self $model): void {
            if (auth()->user()?->isMediator()) {
                $model->mediator_id = auth()->id();
            }
        });
    }

    public function mediator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mediator_id')->onlyMediators();
    }

    public function scopeForMediator(Builder $query, User $user): Builder
    {
        return $query->where("{$query->getModel()->getTable()}.mediator_id", $user->id);
    }
}
