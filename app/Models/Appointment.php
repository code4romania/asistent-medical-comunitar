<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\TimeCast;
use App\Concerns\BelongsToBeneficiary;
use App\Concerns\BelongsToNurse;
use App\Concerns\HasInterventions;
use App\Filament\Resources\AppointmentResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use BelongsToBeneficiary;
    use BelongsToNurse;
    use HasFactory;
    use HasInterventions;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'type',
        'location',
        'attendant',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => TimeCast::class,
        'end_time' => TimeCast::class,
    ];

    public function getUrlAttribute(): string
    {
        return AppointmentResource::getUrl('view', $this);
    }
}
