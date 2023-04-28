<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;

enum InterventionStatus: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case OPEN = 'open';
    case PERFORMED = 'performed';
    case NOT_PERFORMED = 'not_performed';
    case PLANNED = 'planned';

    protected function labelKeyPrefix(): ?string
    {
        return 'intervention.status';
    }
}
