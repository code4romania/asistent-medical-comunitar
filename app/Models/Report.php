<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReportType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [
        // TODO: replace with fillable
    ];

    protected $fillable = [
        'type',
    ];

    protected $casts = [
        'type' => ReportType::class,
    ];
}
