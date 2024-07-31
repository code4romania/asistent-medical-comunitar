<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToNurse;
use App\Concerns\HasBeneficiaryStatus;
use App\Concerns\HasInterventions;
use App\Concerns\HasLocation;
use App\Enums\Beneficiary\Ethnicity;
use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\Type;
use App\Enums\Beneficiary\WorkStatus;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\JoinClause;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class Beneficiary extends Model
{
    use BelongsToNurse;
    use BelongsToThroughTrait;
    use HasBeneficiaryStatus;
    use HasFactory;
    use HasInterventions;
    use HasLocation;
    use LogsActivity;

    protected $fillable = [
        'type',
        'integrated',

        'first_name',
        'last_name',
        'prior_name',

        'cnp',
        'id_type',
        'id_serial',
        'id_number',

        'gender',
        'date_of_birth',

        'ethnicity',
        'work_status',

        'address',
        'phone',
        'notes',
        'reason_removed',

        'nurse_id',
        'family_id',

        'does_not_have_cnp',
        'does_not_provide_cnp',
    ];

    protected $casts = [
        'type' => Type::class,
        'id_type' => IDType::class,
        'gender' => Gender::class,
        'ethnicity' => Ethnicity::class,
        'work_status' => WorkStatus::class,
        'integrated' => 'boolean',
        'date_of_birth' => 'date',
        'does_not_have_cnp' => 'boolean',
        'does_not_provide_cnp' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function ocasionalInterventions(): HasMany
    {
        return $this->hasMany(Intervention\OcasionalIntervention::class);
    }

    public function catagraphy(): HasOne
    {
        return $this->hasOne(Catagraphy::class)
            ->withDefault(function (Catagraphy $catagraphy, self $beneficiary) {
                $catagraphy->fill([
                    'evaluation_date' => today(),
                ]);

                $catagraphy->nurse()->associate(auth()->user());
            });
    }

    public function hasCatagraphy(): bool
    {
        return $this->catagraphy->created_at !== null;
    }

    public function scopeOnlyRegular(Builder $query): Builder
    {
        return $query->where('type', Type::REGULAR);
    }

    public function scopeOnlyOcasional(Builder $query): Builder
    {
        return $query->where('type', Type::OCASIONAL);
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }

    public function getLastNameWithPriorAttribute(): ?string
    {
        if (! $this->prior_name) {
            return $this->last_name;
        }

        return "{$this->last_name} ({$this->prior_name})";
    }

    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->address,
            $this->city?->name,
            $this->county?->name,
        ])
            ->filter()
            ->implode(', ');
    }

    public function getHasUnknownIdentityAttribute(): bool
    {
        return collect([
            $this->first_name,
            $this->last_name,
            $this->gender,
            $this->cnp,
        ])
            ->filter()
            ->isEmpty();
    }

    public function isRegular(): bool
    {
        return $this->type === Type::REGULAR;
    }

    public function isOcasional(): bool
    {
        return $this->type === Type::OCASIONAL;
    }

    public function household(): BelongsToThrough
    {
        return $this->belongsToThrough(Household::class, Family::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function scopeWhereHasVulnerabilities(Builder $query, callable $callback): Builder
    {
        return $query
            ->where('log_name', 'vulnerabilities')
            ->tap($callback)
            ->fromSub(function (QueryBuilder $query) {
                $query
                    ->select([
                        'activity_log.subject_id',
                        'activity_log.subject_type',
                        'activity_log.log_name',
                        'activity_log.properties',
                        'activity_log.created_at',
                        'beneficiaries.id',
                        'beneficiaries.first_name',
                        'beneficiaries.last_name',
                        'beneficiaries.cnp',
                        'beneficiaries.gender',
                        'beneficiaries.date_of_birth',
                        'beneficiaries.county_id',
                        'beneficiaries.city_id',
                        'beneficiaries.status',
                        'beneficiaries.nurse_id',
                    ])
                    ->from('activity_log')
                    ->leftJoin('beneficiaries', function (JoinClause $join) {
                        $join->on('activity_log.subject_id', '=', 'beneficiaries.id')
                            ->where('activity_log.subject_type', 'beneficiary');
                    });
            }, 'activity_log');
    }
}
