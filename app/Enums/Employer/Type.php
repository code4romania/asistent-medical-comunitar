<?php

declare(strict_types=1);

namespace App\Enums\Employer;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Type: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case NGO = 'ngo';
    case DPH = 'dph';
    case GP = 'gp';
    case MUNICIPALITY = 'municipality';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'employer.type';
    }
}
