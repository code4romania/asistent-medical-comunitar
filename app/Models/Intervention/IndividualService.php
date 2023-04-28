<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Models\Beneficiary;
use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualService extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'integrated',
        'status',
        'notes',
        'outside_working_hours',

        'beneficiary_id',
        'case_id',
    ];

    protected $casts = [
        'date' => 'date',
        'integrated' => 'boolean',
        'outside_working_hours' => 'boolean',
    ];

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

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

    public function scopeWhereBeneficiary(Builder $query, ?Beneficiary $beneficiary): Builder
    {
        return $query->where('beneficiary_id', $beneficiary?->id);
    }

    public function scopeWithoutCase(Builder $query): Builder
    {
        return $query->whereNull('case_id');
    }
}
