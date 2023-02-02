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
}
