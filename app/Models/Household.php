<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Household extends Model
{
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

            if (auth()->user()->isNurseOrMediator()) {
                $builder->forUser(auth()->user());
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

    /**
     * Households with a beneficiary assigned to the user or created by the user.
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->whereIn(
            $query->qualifyColumn('id'),
            DB::query()
                ->select('household_id')
                ->fromSub(
                    Family::query()
                        ->forBeneficiariesManagedBy($user)
                        ->select('families.household_id')
                        ->union(
                            Activity::query()
                                ->withoutGlobalScopes()
                                ->withoutEagerLoads()
                                ->select('subject_id')
                                ->where('subject_type', (new static)->getMorphClass())
                                ->forEvent('created')
                                ->causedBy($user)
                        ),
                    'user_households'
                )
        );
    }
}
