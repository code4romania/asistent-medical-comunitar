<?php

declare(strict_types=1);

namespace App\Enums\Employer;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Funding: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case STATE = 'state';
    case LOCAL = 'local';
    case PROJECT = 'project';

    protected function labelKeyPrefix(): ?string
    {
        return 'employer.funding';
    }
}
