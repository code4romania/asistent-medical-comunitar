<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToNurse
{
    public function initializeBelongsToNurse(): void
    {
        $this->fillable[] = 'nurse_id';
    }

    public static function bootBelongsToNurse(): void
    {
        static::creating(function (self $model): void {
            if (auth()->user()?->isNurse()) {
                $model->nurse_id = auth()->id();
            }
        });
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class)->onlyNurses();
    }

    public function scopeForNurse(Builder $query, User $user): Builder
    {
        return $query->where("{$query->getModel()->getTable()}.nurse_id", $user->id);
    }
}
