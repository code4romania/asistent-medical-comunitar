<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToNurse;
use App\Enums\VacationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use BelongsToNurse;
    use HasFactory;

    protected $fillable = [
        'type',
        'start_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'type' => VacationType::class,
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
