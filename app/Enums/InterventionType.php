<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;

enum InterventionType: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case INDIVIDUAL = 'individual';
    case CASE = 'case';
    case OCASIONAL = 'ocasional';

    protected function labelKeyPrefix(): ?string
    {
        return 'intervention.type';
    }
}
