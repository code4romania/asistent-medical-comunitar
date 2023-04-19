<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;

enum Gender: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'gender';
    }
}
