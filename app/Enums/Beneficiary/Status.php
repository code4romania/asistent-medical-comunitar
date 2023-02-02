<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns\ArrayableEnum;

enum Status: string
{
    use ArrayableEnum;

    case REGISTERED = 'registered';
    case CATAGRAPHED = 'catagraphed';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REMOVED = 'removed';

    protected function translationKeyPrefix(): ?string
    {
        return 'beneficiary.status';
    }

    public static function colors(): array
    {
        $colors = [
            'primary' => self::REGISTERED,
            'secondary' => self::CATAGRAPHED,
            'success' => self::ACTIVE,
            'warning' => self::INACTIVE,
            'danger' => self::REMOVED,
        ];

        return collect($colors)
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
