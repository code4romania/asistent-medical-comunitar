<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Concerns\MorphsIntervention;
use App\Enums\Intervention\CaseInitiator;
use App\Models\Intervention;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterventionableCase extends Model
{
    use MorphsIntervention;
    use HasFactory;

    protected $fillable = [
        'name',
        'initiator',
        'is_imported',
    ];

    protected $casts = [
        'initiator' => CaseInitiator::class,
        'is_imported' => 'boolean',
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
        return $this->hasMany(Intervention::class, 'parent_id')
            ->onlyIndividualServices();
    }
}
