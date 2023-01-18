<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\AlphabeticalOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'county_id',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new AlphabeticalOrder);
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }
}
