<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait ModelAsOptions
{
    public static function cachedList(): Collection
    {
        $key = Str::of(__CLASS__)
            ->classBasename()
            ->pluralStudly()
            ->snake()
            ->value();

        return Cache::driver('array')
            ->remember(
                $key,
                MINUTE_IN_SECONDS,
                fn () => static::query()
                    ->when(method_exists(static::class, 'modelAsOptionsQuery'), fn (Builder $query) => static::modelAsOptionsQuery($query))
                    ->with('category')
                    ->get()
                    ->keyBy('id')
            );
    }

    public static function allAsOptions(): Collection
    {
        return static::cachedList()
            ->groupBy('category_id')
            ->map->pluck('name', 'id');
    }

    public static function allAsFlatOptions(): Collection
    {
        return static::cachedList()
            ->pluck('name', 'id');
    }
}
