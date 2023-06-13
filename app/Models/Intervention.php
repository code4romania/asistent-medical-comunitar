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
use App\Models\Scopes\CurrentNurseBeneficiaryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    ];

    protected $casts = [
        'integrated' => 'boolean',
    ];

    protected $with = [
        'appointment',
        'interventionable',
    ];

    public static function booted(): void
    {
        static::addGlobalScope(new CurrentNurseBeneficiaryScope);
    }

    public function interventionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function vulnerability(): BelongsTo
    {
        return $this->belongsTo(Vulnerability::class)
            ->withDefault(function (Vulnerability $vulnerability, self $intervention) {
                return $intervention->parent?->vulnerability;
            });
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->whereMorphedTo('interventionable', InterventionableIndividualService::class);
    }

    public function realizedInterventions(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->whereMorphRelation('interventionable', InterventionableIndividualService::class, 'status', Status::REALIZED);
    }

    public function isCase(): bool
    {
        return $this->getActualClassNameForMorph($this->interventionable_type) === InterventionableCase::class;
    }

    public function isIndividualService(): bool
    {
        return $this->getActualClassNameForMorph($this->interventionable_type) === InterventionableIndividualService::class;
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
            return $this->interventionable->status;
        }

        return $this->interventionable->status?->label();
    }

    public function getServicesAttribute(): string
    {
        if ($this->interventionable instanceof InterventionableCase) {
            $performed = $this->realized_interventions_count;
            $total = $this->interventions_count;
        } else {
            $performed = $this->interventionable->status->is(Status::REALIZED) ? 1 : 0;
            $total = 1;
        }

        return $performed . '/' . $total;
    }

    public function getUrlAttribute(): string
    {
        return BeneficiaryResource::getUrl('interventions.view', [
            'beneficiary' => $this->beneficiary_id,
            'record' => $this->id,
        ]);
    }
}
