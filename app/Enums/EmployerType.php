<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;

enum EmployerType: string
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
