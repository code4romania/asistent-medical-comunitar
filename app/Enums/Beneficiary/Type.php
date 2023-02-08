<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;
use App\Contracts;

enum Type: string implements Contracts\Enums\HasColors
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\HasColors;

    case REGULAR = 'regular';
    case OCASIONAL = 'ocasional';

    protected function translationKeyPrefix(): ?string
    {
        return 'beneficiary.type';
    }

    public static function colorMap(): array
    {
        return [
            'primary' => self::REGULAR,
            'bg-violet-100 text-violet-800' => self::OCASIONAL,
        ];
    }
}
