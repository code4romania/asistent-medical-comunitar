<?php

declare(strict_types=1);

namespace App\Enums\Report\Indicator;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Beneficiaries: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case TOTAL = 'total';
    case REGISTERED = 'registered';
    case CATAGRAPHED = 'catagraphed';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REMOVED = 'removed';
    // case OCASIONAL = 'ocasional';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.indicator.value.beneficiaries';
    }
}
