<?php

declare(strict_types=1);

namespace App\Enums\Report;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case LIST = 'list';
    case STATISTIC = 'statistic';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::LIST => __('report.type.list'),
            self::STATISTIC => __('report.type.statistic'),
        };
    }
}
