<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Concerns\HasInterventions;
use App\Enums\Intervention\CaseInitiator;
use App\Models\Beneficiary;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseManagement extends Model
{
    use HasFactory;
    use HasInterventions;

    protected $table = 'cases';

    protected $fillable = [
        'name',
        'initiator',
        'integrated',
        'imported',

        'beneficiary_id',
    ];

    protected $casts = [
        'initiator' => CaseInitiator::class,
        'integrated' => 'boolean',
        'imported' => 'boolean',
    ];

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function vulnerability(): BelongsTo
    {
        return $this->belongsTo(Vulnerability::class);
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(IndividualService::class, 'case_id');
    }
}
