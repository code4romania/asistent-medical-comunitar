<?php

declare(strict_types=1);

namespace App\Enums\Intervention;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Status: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case PLANNED = 'planned';
    case REALIZED = 'realized';
    case UNREALIZED = 'unrealized';

    protected function labelKeyPrefix(): ?string
    {
        return 'intervention.status';
    }
}
