<?php

declare(strict_types=1);

namespace App\Enums\Employer;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Funding: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case STATE = 'state';
    case LOCAL = 'local';
    case PROJECT = 'project';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::STATE => __('employer.funding.state'),
            self::LOCAL => __('employer.funding.local'),
            self::PROJECT => __('employer.funding.project'),
        };
    }
}
