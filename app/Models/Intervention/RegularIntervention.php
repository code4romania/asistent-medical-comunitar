<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Models\Beneficiary;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegularIntervention extends Model
{
    use HasFactory;

    protected $table = 'interventions_regular';

    protected $fillable = [
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
}
