<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disability extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'degree',
        'diagnostic',
        'diagnostic_code',
        'receives_pension',
        'start_year',
        'notes',
        'catagraphy_id',
    ];

    protected $casts = [
        'type' => 'string',
        'degree' => 'string',
        'diagnostic' => 'string',
        'diagnostic_code' => 'string',
        'receives_pension' => 'boolean',
        'start_year' => 'int',
        'notes' => 'string',
    ];

    public function catagraphy(): BelongsTo
    {
        return $this->belongsTo(Catagraphy::class);
    }
}
