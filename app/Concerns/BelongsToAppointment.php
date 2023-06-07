<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToAppointment
{
    public function initializeBelongsToAppointment(): void
    {
        $this->fillable[] = 'appointment_id';
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
