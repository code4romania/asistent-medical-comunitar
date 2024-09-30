<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;

enum VacationType: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
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
