<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToAppointment;
use App\Concerns\BelongsToBeneficiary;
use App\Concerns\BelongsToVulnerability;
use App\Enums\Intervention\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Models\Intervention\InterventionableCase;
use App\Models\Intervention\InterventionableIndividualService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Intervention extends Model
{
    use BelongsToAppointment;
    use BelongsToBeneficiary;
    use BelongsToVulnerability;
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'integrated',
        'notes',
        'appointment_id',
        'beneficiary_id',
        'parent_id',
        'vulnerability_id',
        'vulnerability_label',
        'closed_at',
    ];

    protected $casts = [
        'integrated' => 'boolean',
        'closed_at' => 'datetime',
    ];

    protected $with = [
        'appointment',
        'interventionable',
    ];

    public static function booted(): void
    {
        static::addGlobalScope('forCurrentUser', function (Builder $builder) {
            if (! auth()->check()) {
                return;
            }

            if (auth()->user()->isAdmin()) {
                return;
            }

            $builder->forUser(auth()->user());
        });

        static::creating(function (self $intervention) {
            if (! $intervention->isIndividualService()) {
                return;
            }

            if (! $intervention->interventionable->isRealized()) {
                return;
            }

            $intervention->closed_at = $intervention->interventionable->date ?? now();
        });

        static::created(function (self $intervention) {
            if ($intervention->beneficiary->isCatagraphed()) {
                $intervention->beneficiary->markAsActive();
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

    public function interventionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function appointments(): HasManyThrough
    {
        return $this
            ->hasManyThrough(
                Appointment::class,
                self::class,
                'parent_id',
                'id',
                'id',
                'appointment_id'
            )->distinct();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->onlyIndividualServices();
    }

    public function scopeWhereRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOnlyOpen(Builder $query): Builder
    {
        return $query->whereNull('closed_at');
    }

    public function scopeOnlyCases(Builder $query): Builder
    {
        return $query->whereMorphedTo('interventionable', InterventionableCase::class);
    }

    public function scopeOnlyIndividualServices(Builder $query): Builder
    {
        return $query->whereMorphedTo('interventionable', InterventionableIndividualService::class);
    }

    public function scopeOnlyRealized(Builder $query): Builder
    {
        return $query->whereMorphRelation('interventionable', InterventionableIndividualService::class, 'status', Status::REALIZED);
    }

    public function scopeOnlyPlanned(Builder $query): Builder
    {
        return $query->whereMorphRelation('interventionable', InterventionableIndividualService::class, 'status', Status::PLANNED);
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        if ($user->isNurse()) {
            return $query->whereRelation('beneficiary', 'nurse_id', $user->id);
        }

        if ($user->isCoordinator()) {
            return $query->whereRelation('beneficiary.nurse', 'activity_county_id', $user->county_id);
        }

        return $query;
    }

    public function scopeWhereRealizedIndividualServiceWithCode(Builder $query, string $code): Builder
    {
        return $query
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->whereHasMorph(
                'interventionable',
                InterventionableIndividualService::class,
                fn (Builder $query) => $query
                    ->whereRelation('service', 'code', $code)
                    ->where('status', Status::REALIZED)
            );
    }

    public function isCase(): bool
    {
        return $this->getActualClassNameForMorph($this->interventionable_type) === InterventionableCase::class;
    }

    public function isIndividualService(): bool
    {
        return $this->getActualClassNameForMorph($this->interventionable_type) === InterventionableIndividualService::class;
    }

    public function isOpen(): bool
    {
        if (! $this->isCase()) {
            return true;
        }

        return \is_null($this->closed_at);
    }

    public function open(): void
    {
        if (! $this->isCase()) {
            return;
        }

        $this->update([
            'closed_at' => null,
        ]);
    }

    public function close(): void
    {
        if (! $this->isCase()) {
            return;
        }

        $this->update([
            'closed_at' => $this->freshTimestamp(),
        ]);
    }

    public function getNameAttribute(): ?string
    {
        return match ($this->getActualClassNameForMorph($this->interventionable_type)) {
            InterventionableCase::class => $this->interventionable->name,
            InterventionableIndividualService::class => $this->interventionable->service?->name,
            default => null,
        };
    }

    public function getTypeAttribute(): string
    {
        if ($this->interventionable instanceof InterventionableCase) {
            return $this->interventionable->is_imported
                ? __('intervention.type.ocasional')
                : __('intervention.type.case');
        }

        return __('intervention.type.individual');
    }

    public function getStatusAttribute(): ?string
    {
        if ($this->interventionable instanceof InterventionableCase) {
            return $this->isOpen()
                ? __('intervention.status.open')
                : __('intervention.status.closed');
        }

        return $this->interventionable->status?->label();
    }

    public function getServicesAttribute(): string
    {
        return $this->realized_services_count . '/' . $this->all_services_count;
    }

    public function getAllServicesCountAttribute(): int
    {
        if ($this->interventionable instanceof InterventionableCase) {
            return $this->interventions_count;
        }

        return 1;
    }

    public function getRealizedServicesCountAttribute(): int
    {
        if ($this->interventionable instanceof InterventionableCase) {
            return $this->realized_interventions_count;
        }

        return $this->interventionable->status->is(Status::REALIZED) ? 1 : 0;
    }

    public function getUrlAttribute(): string
    {
        return BeneficiaryResource::getUrl('interventions.view', [
            'beneficiary' => $this->beneficiary_id,
            'record' => $this->id,
        ]);
    }

    public function getVulnerabilityLabelAttribute(): ?string
    {
        return $this->attributes['vulnerability_label'] ?? $this->vulnerability?->name;
    }

    public function setVulnerability($index)
    {
        $vulnerability = $this->beneficiary
            ->catagraphy
            ->all_valid_vulnerabilities
            ->get($index);

        return $this->fill([
            'vulnerability_id' => $vulnerability?->value,
            'vulnerability_label' => $vulnerability?->label,
        ]);
    }
}
