<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;
use App\Contracts;

enum Type: string implements Contracts\Enums\HasColor
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasColor;
    use Concerns\Enums\HasLabel;

    case REGULAR = 'regular';
    case OCASIONAL = 'ocasional';

    protected function labelKeyPrefix(): ?string
    {
        return 'beneficiary.type';
    }

    public static function colors(): array
    {
        return [
            'regular' => 'primary',
            'ocasional' => 'bg-violet-100 text-violet-800',
        ];
    }
}
