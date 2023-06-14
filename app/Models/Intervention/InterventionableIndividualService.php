<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Concerns\BelongsToAppointment;
use App\Concerns\BelongsToBeneficiary;
use App\Concerns\MorphsIntervention;
use App\Enums\Intervention\Status;
use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterventionableIndividualService extends Model
{
    use BelongsToAppointment;
    use BelongsToBeneficiary;
    use MorphsIntervention;
    use HasFactory;

    protected $fillable = [
        'date',
        'status',
        'notes',
        'outside_working_hours',
        'service_id',
    ];

    protected $casts = [
        'date' => 'date',
        'outside_working_hours' => 'boolean',
        'status' => Status::class,
    ];

    protected $with = [
        'service',
    ];

    protected static function booted(): void
    {
        static::updating(function (self $interventionable) {
            if ($interventionable->isDirty('status')) {
                $interventionable->intervention()->update([
                    'closed_at' => $interventionable->status->is(Status::REALIZED)
                        ? $interventionable->freshTimestamp()
                        : null,
                ]);
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function vulnerability(): BelongsTo
    {
        return $this->belongsTo(Vulnerability::class);
    }
}
