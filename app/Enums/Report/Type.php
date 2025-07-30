<?php

declare(strict_types=1);

namespace App\Enums\Report;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Type: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case LIST = 'list';
    case STATISTIC = 'statistic';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.type';
    }
}
