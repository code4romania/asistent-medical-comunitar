<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\AlphabeticalOrder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'level',
        'type',
        'name',
        'county_id',
        'parent_id',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new AlphabeticalOrder);
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query
            ->with('parent')
            ->where(function (Builder $query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhereHas('parent', function (Builder $query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
    }

    public function getParentNameAttribute(): ?string
    {
        if (
            \in_array($this->type, [11, 19, 22, 23]) &&
            $this->parent_id !== null
        ) {
            return $this->parent->name;
        }

        return null;
    }
}
