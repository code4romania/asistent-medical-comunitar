<?php

declare(strict_types=1);

namespace App\Concerns\Enums;

trait HasColors
{
    public static function colorMap(): array
    {
        return [];
    }

    public static function colors(): array
    {
        return collect(static::colorMap())
            ->map->value
            ->all();
    }

    public function color(): ?string
    {
        return collect(static::colors())
            ->flip()
            ->get($this->value);
    }
}
