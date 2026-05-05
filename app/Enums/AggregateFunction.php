<?php

declare(strict_types=1);

namespace App\Enums;

use CommitGlobal\Enums\Concerns\Comparable;

enum AggregateFunction: string
{
    use Comparable;

    case COUNT = 'count';
    case SUM = 'sum';
    case AVG = 'avg';
    case MIN = 'min';
    case MAX = 'max';
}
