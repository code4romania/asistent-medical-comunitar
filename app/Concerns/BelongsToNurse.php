<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Scopes\CurrentNurseScope;
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
        static::addGlobalScope(new CurrentNurseScope);
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class)->onlyNurses();
    }

    public function scopeWhereNurse(Builder $query, User $user): Builder
    {
        return $query->whereBelongsTo($user, 'nurse');
    }
}
