<?php

declare(strict_types=1);

namespace App\Enums\Employer;

use App\Concerns;

enum Funding: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case STATE = 'state';
    case LOCAL = 'local';
    case PROJECT = 'project';

    protected function labelKeyPrefix(): ?string
    {
        return 'employer.funding';
    }
}
