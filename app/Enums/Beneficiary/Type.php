<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns\ArrayableEnum;

enum Type: string
{
    use ArrayableEnum;

    case regular = 'regular';
    case ocasional = 'ocasional';

    protected function translationKeyPrefix(): ?string
    {
        return 'beneficiary.type';
    }
}
