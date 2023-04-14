<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;

enum Integrated: int
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case YES = 1;
    case NO = 0;

    protected function labelKeyPrefix(): ?string
    {
        return 'beneficiary.integrated';
    }
}
