<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum WorkStatus: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case YES = 'yes';
    case NO = 'no';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'beneficiary.work_status';
    }
}
