<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToNurse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Household extends Model
{
    use BelongsToNurse;
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('forCurrentUser', function (Builder $builder): void {
            if (! auth()->check()) {
                return;
            }
            if (auth()->user()->isNurse()) {
                $builder->forNurse(auth()->user());
            }

            if (auth()->user()->isMediator()) {
                $builder->forMediator(auth()->user());
            }
        });
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    public function beneficiaries(): HasManyThrough
    {
        return $this->hasManyThrough(Beneficiary::class, Family::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function scopeForMediator(Builder $query, User $user): Builder
    {
        return $query->whereRelation('beneficiaries', 'mediator_id', $user->id);
    }

    public static function createForCurrentNurse(array $data): self
    {
        // A mediator's id must never be stored in nurse_id; mediator-owned
        // households are reached through their member beneficiaries instead.
        if (auth()->user()?->isNurse()) {
            $data['nurse_id'] = auth()->id();
        }

        return self::create($data);
    }
}
