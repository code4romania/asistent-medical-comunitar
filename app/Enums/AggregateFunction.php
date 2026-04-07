<?php

declare(strict_types=1);

namespace App\Enums;

enum AggregateFunction: string
{
    case COUNT = 'count';
    case SUM = 'sum';
    case AVG = 'avg';
    case MIN = 'min';
    case MAX = 'max';
}
