<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\AlphabeticalOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class County extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'siruta',
        'name',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new AlphabeticalOrder);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public static function cachedList(): Collection
    {
        return Cache::driver('array')
            ->remember(
                'counties',
                MINUTE_IN_SECONDS,
                fn () => static::pluck('name', 'id')
            );
    }
}
