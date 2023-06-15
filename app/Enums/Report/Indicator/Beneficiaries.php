<?php

declare(strict_types=1);

namespace App\Enums\Report\Indicator;

use App\Concerns;

enum Beneficiaries: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case TOTAL = 'total';
    case REGISTERED = 'registered';
    case CATAGRAPHED = 'catagraphed';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REMOVED = 'removed';
    case OCASIONAL = 'ocasional';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.indicator.beneficiaries';
    }
}
