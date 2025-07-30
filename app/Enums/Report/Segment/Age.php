<?php

declare(strict_types=1);

namespace App\Enums\Report\Segment;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Age: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case VCV_01 = 'VCV_01';
    case VCV_02 = 'VCV_02';
    case VCV_03 = 'VCV_03';
    case VCV_04 = 'VCV_04';
    case VCV_05 = 'VCV_05';
    case VCV_06 = 'VCV_06';
    case TOTAL = 'total';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.segment.value.age';
    }
}
