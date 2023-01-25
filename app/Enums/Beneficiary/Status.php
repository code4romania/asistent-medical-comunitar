<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns\ArrayableEnum;

enum Status: string
{
    use ArrayableEnum;

    case registered = 'registered';
    case catagraphed = 'catagraphed';
    case active = 'active';
    case inactive = 'inactive';
    case removed = 'removed';

    protected function translationKeyPrefix(): ?string
    {
        return 'beneficiary.status';
    }
}
