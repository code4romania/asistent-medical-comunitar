<?php

declare(strict_types=1);

namespace App\Enums\Intervention;

use App\Concerns;

enum Status: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case PLANNED = 'planned';
    case REALIZED = 'realized';
    case UNREALIZED = 'unrealized';

    protected function labelKeyPrefix(): ?string
    {
        return 'intervention.status';
    }
}
