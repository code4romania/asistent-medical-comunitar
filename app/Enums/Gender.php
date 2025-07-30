<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Gender: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'gender';
    }
}
