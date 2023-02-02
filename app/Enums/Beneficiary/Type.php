<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns\ArrayableEnum;

enum Type: string
{
    use ArrayableEnum;

    case REGULAR = 'regular';
    case OCASIONAL = 'ocasional';

    protected function translationKeyPrefix(): ?string
    {
        return 'beneficiary.type';
    }
}
