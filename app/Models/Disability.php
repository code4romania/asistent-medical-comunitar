<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToCatagraphy;
use App\Concerns\HasDiagnostic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    use BelongsToCatagraphy;
    use HasDiagnostic;
    use HasFactory;

    protected $fillable = [
        'type',
        'degree',
        'receives_pension',
        'has_certificate',
        'start_year',
        'notes',
    ];

    protected $casts = [
        'type' => 'string',
        'degree' => 'string',
        'receives_pension' => 'boolean',
        'has_certificate' => 'boolean',
        'start_year' => 'int',
        'notes' => 'string',
    ];

    protected $with = [
        'diagnostic',
    ];

    public function getCertificateVulnerabilityAttribute(): string
    {
        return $this->has_certificate ? 'VDH_01' : 'VDH_02';
    }
}
