<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;
use App\Contracts;

enum Status: string implements Contracts\Enums\HasColors
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasColors;

    case REGISTERED = 'registered';
    case CATAGRAPHED = 'catagraphed';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REMOVED = 'removed';

    protected function translationKeyPrefix(): ?string
    {
        return 'beneficiary.status';
    }

    public static function colorMap(): array
    {
        return [
            'bg-amber-100 text-amber-800' => self::REGISTERED,
            'bg-blue-100 text-blue-800' => self::CATAGRAPHED,
            'bg-emerald-100 text-emerald-800' => self::ACTIVE,
            'bg-gray-100 text-gray-800' => self::INACTIVE,
            'bg-pink-100 text-pink-800' => self::REMOVED,
        ];
    }
}
