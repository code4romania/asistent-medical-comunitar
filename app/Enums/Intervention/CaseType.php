<?php

declare(strict_types=1);

namespace App\Enums\Intervention;

use App\Concerns;

enum CaseType: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case CASE = 'case';
    case OCASIONAL = 'ocasional';

    protected function labelKeyPrefix(): ?string
    {
        return 'case.type';
    }
}
