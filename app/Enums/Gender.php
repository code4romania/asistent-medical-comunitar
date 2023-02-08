<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;

enum Gender: string
{
    use Arrayable;

    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';

    protected function translationKeyPrefix(): ?string
    {
        return 'gender';
    }
}
