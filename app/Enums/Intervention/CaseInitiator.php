<?php

declare(strict_types=1);

namespace App\Enums\Intervention;

use App\Concerns;

enum CaseInitiator: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case NURSE = 'nurse';
    case GP = 'gp';
    case TEAM = 'team';
    case DPH = 'dph';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'intervention.initiator';
    }
}
