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
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Intervention extends Model
{
    use BelongsToAppointment;
    use BelongsToBeneficiary;
    use BelongsToVulnerability;
    use HasFactory;

    protected $fillable = [
        'integrated',
        'notes',
        'appointment_id',
        'beneficiary_id',
        'parent_id',
        'vulnerability_id',
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

            if (auth()->iser()->isAdmin()) {
                return;
            }

            $builder->whereHas('beneficiary');
        });

        static::created(function (self $intervention): void {
            if ($intervention->beneficiary->isCatagraphed()) {
                $intervention->beneficiary->markAsActive();
            }
        });
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

    public function vulnerability(): BelongsTo
    {
        return $this->belongsTo(Vulnerability::class);
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
            InterventionableIndividualService::class => $this->interventionable->service->name,
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
}
