<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToCatagraphy;
use App\Enums\Suspicion\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspicion extends Model
{
    use BelongsToCatagraphy;
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'elements',
        'notes',
    ];

    protected $casts = [
        'name' => 'string',
        'category' => Category::class,
        'elements' => 'collection', // TODO: replace with actual data after getting element definitions
        'notes' => 'string',
    ];
}
