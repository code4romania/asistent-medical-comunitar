<?php

declare(strict_types=1);

namespace App\Models\Service;

use App\Concerns\ModelAsOptions;
use App\Contracts\Stringable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model implements Stringable
{
    use ModelAsOptions;

    public $timestamps = false;

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function scopeWhereEnabled(Builder $query): Builder
    {
        return $query->where('is_enabled', true);
    }

    public static function modelAsOptionsQuery(Builder $query): Builder
    {
        return $query->whereEnabled();
    }
}
