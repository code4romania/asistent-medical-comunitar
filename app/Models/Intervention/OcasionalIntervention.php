<?php

declare(strict_types=1);

namespace App\Models\Intervention;

use App\Concerns\BelongsToBeneficiary;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OcasionalIntervention extends Model
{
    use BelongsToBeneficiary;
    use HasFactory;

    protected $fillable = [
        'reason',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
