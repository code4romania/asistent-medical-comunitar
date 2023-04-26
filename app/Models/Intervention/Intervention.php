<?php

declare(strict_types=1);

namespace App\Models\Intervention;

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
        'reason',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
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
}
