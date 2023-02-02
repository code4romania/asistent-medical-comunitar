<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum Gender: string
{
    use ArrayableEnum;

    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';

    protected function translationKeyPrefix(): ?string
    {
        return 'gender';
    }
}
