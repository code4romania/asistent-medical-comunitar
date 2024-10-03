<?php

declare(strict_types=1);

namespace App\Enums\Report;

use App\Concerns;
use App\Contracts;

enum Status: string implements Contracts\Enums\HasColor
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasColor;
    use Concerns\Enums\HasLabel;

    case PENDING = 'pending';
    case FINISHED = 'finished';
    case FAILED = 'failed';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.status';
    }

    public static function colors(): array
    {
        return [
            'pending' => 'bg-blue-100 text-blue-800',
            'finished' => 'bg-success-100 text-success-800',
            'failed' => 'bg-danger-100 text-danger-800',
        ];
    }
}
