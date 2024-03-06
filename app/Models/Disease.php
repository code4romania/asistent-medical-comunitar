<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToCatagraphy;
use App\Concerns\HasDiagnostic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use BelongsToCatagraphy;
    use HasDiagnostic;
    use HasFactory;

    protected $fillable = [
        'type',
        'category',
        'start_year',
        'notes',
    ];

    protected $casts = [
        'type' => 'string',
        'category' => 'string',
        'start_year' => 'int',
        'notes' => 'string',
    ];

    protected $with = [
        'diagnostic',
    ];
}
