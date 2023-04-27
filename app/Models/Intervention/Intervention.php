<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Enums\InterventionType;
use App\Models\Beneficiary;
use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalnoy\Nestedset\NodeTrait;

class Intervention extends Model
{
    use HasFactory;
    use NodeTrait;

    protected $table = 'interventions_regular';

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
