<?php

declare(strict_types=1);

namespace App\Enums\Report\Segment;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Gender: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';
    case TOTAL = 'total';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.segment.value.gender';
    }
}
