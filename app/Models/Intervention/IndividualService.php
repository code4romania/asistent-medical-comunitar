<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Enums\InterventionType;
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
        'beneficiary_id',
        'type',
        'reason',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
        'type' => InterventionType::class,
    ];

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
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
        return $query->whereNull('case_management_id');
    }

    public function isIndividual(): bool
    {
        return $this->type->is(InterventionType::INDIVIDUAL);
    }

    public function isCase(): bool
    {
        return $this->type->is(InterventionType::CASE);
    }

    public function isOcasional(): bool
    {
        return $this->type->is(InterventionType::OCASIONAL);
    }
}
