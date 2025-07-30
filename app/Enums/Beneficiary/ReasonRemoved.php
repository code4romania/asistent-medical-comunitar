<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum ReasonRemoved: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case DECEASED_HOME = 'deceased_home';
    case DECEASED_HOSPITAL = 'deceased_hospital';
    case RELOCATED_CITY = 'relocated_city';
    case RELOCATED_ABROAD = 'relocated_abroad';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'beneficiary.reason_removed';
    }
}
