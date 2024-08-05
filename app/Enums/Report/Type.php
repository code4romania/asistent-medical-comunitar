<?php

declare(strict_types=1);

namespace App\Enums\Report;

use App\Concerns;

enum Type: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case LIST = 'list';
    case STATISTIC = 'statistic';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.type';
    }
}
