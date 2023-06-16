<?php

declare(strict_types=1);

namespace App\Enums\Report\Segment;

use App\Concerns;

enum Gender: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';
    case TOTAL = 'total';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.segment.gender';
    }
}
