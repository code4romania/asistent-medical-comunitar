<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToAppointment;
use App\Concerns\BelongsToBeneficiary;
use App\Concerns\BelongsToVulnerability;
use App\Models\Intervention\InterventionableCase;
use App\Models\Intervention\InterventionableIndividualService;
use App\Models\Scopes\CurrentNurseBeneficiaryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Intervention extends Model
{
    use BelongsToAppointment;
    use BelongsToBeneficiary;
    use BelongsToVulnerability;
    use HasFactory;

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

    public function case(): BelongsTo
    {
        return $this->belongsTo(InterventionableCase::class);
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
                ? __('case.type.ocasional')
                : __('case.type.case');
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
        $performed = 0;
        $total = 0;

        // if ($this->interventionable instanceof InterventionableCase) {
        //     $performed = $this->interventionable->realized_interventions_count;
        //     $total = $this->interventionable->interventions_count;
        // } else {
        //     $performed = $this->interventionable->status->is(Status::REALIZED) ? 1 : 0;
        //     $total = 1;
        // }

        return $performed . '/' . $total;
    }
}
