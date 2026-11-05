<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Family extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'household_id',
    ];

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    public function scopeForBeneficiariesManagedBy(Builder $query, User $user): Builder
    {
        $userColumn = match (true) {
            $user->isNurse() => 'beneficiaries.nurse_id',
            $user->isMediator() => 'beneficiaries.mediator_id',
        };

        return $query
            ->join('beneficiaries', 'beneficiaries.family_id', 'families.id')
            ->where($userColumn, $user->id);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }
}
