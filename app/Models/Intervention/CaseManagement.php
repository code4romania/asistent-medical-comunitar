<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Concerns\BelongsToBeneficiary;
use App\Enums\Intervention\CaseInitiator;
use App\Models\Appointment;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class CaseManagement extends Model
{
    use BelongsToBeneficiary;
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = [
        'name',
        'initiator',
        'integrated',
        'imported',
        'closed_at',
        'notes',
    ];

    protected $casts = [
        'initiator' => CaseInitiator::class,
        'integrated' => 'boolean',
        'imported' => 'boolean',
        'closed_at' => 'datetime',
    ];

    public function vulnerability(): BelongsTo
    {
        return $this->belongsTo(Vulnerability::class);
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(IndividualService::class, 'case_id');
    }

    public function appointments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Appointment::class,
            IndividualService::class,
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
