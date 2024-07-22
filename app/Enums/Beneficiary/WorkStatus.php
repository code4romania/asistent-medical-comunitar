<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;

enum WorkStatus: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case YES = 'yes';
    case NO = 'no';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'beneficiary.work_status';
    }
}
