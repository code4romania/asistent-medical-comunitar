<?php

declare(strict_types=1);

namespace App\Enums\Intervention;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum CaseInitiator: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case NURSE = 'nurse';
    case GP = 'gp';
    case SPECIALIST = 'specialist';
    case TEAM = 'team';
    case DPH = 'dph';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'intervention.initiator';
    }
}
