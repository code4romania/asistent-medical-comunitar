<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Models\Beneficiary;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OcasionalIntervention extends Model
{
    use HasFactory;

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

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
