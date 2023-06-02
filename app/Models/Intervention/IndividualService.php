<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Concerns\BelongsToAppointment;
use App\Concerns\BelongsToBeneficiary;
use App\Enums\Intervention\Status;
use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualService extends Model
{
    use BelongsToAppointment;
    use BelongsToBeneficiary;
    use HasFactory;

    protected $fillable = [
        'date',
        'integrated',
        'status',
        'notes',
        'outside_working_hours',
        'case_id',
    ];

    protected $casts = [
        'date' => 'date',
        'integrated' => 'boolean',
        'outside_working_hours' => 'boolean',
        'status' => Status::class,
    ];

    public function case(): BelongsTo
    {
        return $this->belongsTo(CaseManagement::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function vulnerability(): BelongsTo
    {
        return $this->belongsTo(Vulnerability::class);
    }

    public function scopeWithoutCase(Builder $query): Builder
    {
        return $query->whereNull('case_id');
    }
}
