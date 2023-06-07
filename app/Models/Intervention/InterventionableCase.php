<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Concerns\MorphsIntervention;
use App\Enums\Intervention\CaseInitiator;
use App\Models\Appointment;
use App\Models\Intervention;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class InterventionableCase extends Model
{
    use MorphsIntervention;
    use HasFactory;

    protected $fillable = [
        'name',
        'initiator',
        'integrated',
        'is_imported',
        'closed_at',
        'notes',
    ];

    protected $casts = [
        'initiator' => CaseInitiator::class,
        'integrated' => 'boolean',
        'is_imported' => 'boolean',
        'closed_at' => 'datetime',
    ];

    protected $withCount = [
        'interventions',
    ];

    public function vulnerability(): BelongsTo
    {
        return $this->belongsTo(Vulnerability::class);
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class, 'case_id')
            ->whereMorphedTo('interventionable', InterventionableIndividualService::class);
    }

    public function appointments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Appointment::class,
            InterventionableIndividualService::class,
            'case_id',
            'id',
            'id',
            'appointment_id'
        );
    }

    public function isOpen(): bool
    {
        return \is_null($this->closed_at);
    }

    public function getStatusAttribute(): string
    {
        return $this->isOpen()
            ? __('intervention.status.open')
            : __('intervention.status.closed');
    }

    public function scopeOnlyOpen(Builder $query): Builder
    {
        return $query->whereNull('closed_at');
    }

    public function open(): void
    {
        $this->update([
            'closed_at' => null,
        ]);
    }

    public function close(): void
    {
        $this->update([
            'closed_at' => $this->freshTimestamp(),
        ]);
    }
}
