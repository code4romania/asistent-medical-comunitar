<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToNurse;
use App\Concerns\HasInterventions;
use App\Concerns\HasLocation;
use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\Status;
use App\Enums\Beneficiary\Type;
use App\Enums\Gender;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class Beneficiary extends Model
{
    use BelongsToNurse;
    use BelongsToThroughTrait;
    use HasFactory;
    use HasInterventions;
    use HasLocation;
    use LogsActivity;

    protected $fillable = [
        'type',
        'status',
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

        'address',
        'phone',
        'notes',
        'reason_removed',

        'nurse_id',
        'family_id',
    ];

    protected $casts = [
        'type' => Type::class,
        'status' => Status::class,
        'id_type' => IDType::class,
        'gender' => Gender::class,
        'integrated' => 'boolean',
        'date_of_birth' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function (self $beneficiary) {
            if ($beneficiary->isRegular() && ! $beneficiary->status) {
                $beneficiary->status = Status::REGISTERED;
            }
        });

        static::updating(function (self $beneficiary) {
            if ($beneficiary->isRegular() && $beneficiary->isDirty('type')) {
                $beneficiary->status = Status::REGISTERED;
            }
        });
    }

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

    public function scopeOnlyRegular(Builder $query): Builder
    {
        return $query->where('type', Type::REGULAR);
    }

    public function scopeOnlyOcasional(Builder $query): Builder
    {
        return $query->where('type', Type::OCASIONAL);
    }

    public function scopeOnlyActive(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE);
    }

    public function scopeOnlyInactive(Builder $query): Builder
    {
        return $query->where('status', Status::INACTIVE);
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

    public function getDoesNotHaveCnpAttribute(): bool
    {
        return \is_null($this->cnp);
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

    public function changeStatus(Status | string $status): void
    {
        if (\is_string($status)) {
            $status = Status::tryFrom($status);
        }

        $this->update([
            'status' => $status,
        ]);
    }
}
