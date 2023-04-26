<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'category',
        'diagnostic',
        'diagnostic_code',
        'start_year',
        'notes',
        'catagraphy_id',
    ];

    protected $casts = [
        'type' => 'string',
        'category' => 'string',
        'diagnostic' => 'string',
        'diagnostic_code' => 'string',
        'start_year' => 'int',
        'notes' => 'string',
    ];
}
