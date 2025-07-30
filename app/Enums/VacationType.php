<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum VacationType: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case MEDICAL = 'medical';
    case REST = 'rest';
    case CHILD = 'child';
    case special = 'special';
    case BLOOD_DONATION = 'blood_donation';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'vacation.type';
    }
}
