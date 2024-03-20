<?php

declare(strict_types=1);

namespace App\Enums\Employer;

use App\Concerns;

enum Type: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
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
