<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;

enum EmployerType: string
{
    use Arrayable;

    case NGO = 'ngo';
    case DPH = 'dph';
    case GP = 'gp';
    case MUNICIPALITY = 'municipality';
    case OTHER = 'other';

    protected function translationKeyPrefix(): ?string
    {
        return 'employer.type';
    }
}
