<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;
use App\Contracts;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Status: string implements Contracts\Enums\HasColor
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasColor;
    use Concerns\Enums\HasLabel;

    case REGISTERED = 'registered';
    case CATAGRAPHED = 'catagraphed';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REMOVED = 'removed';

    protected function labelKeyPrefix(): ?string
    {
        return 'beneficiary.status';
    }

    public static function colors(): array
    {
        return [
            'registered' => 'bg-amber-100 text-amber-800',
            'catagraphed' => 'bg-blue-100 text-blue-800',
            'active' => 'bg-emerald-100 text-emerald-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            'removed' => 'bg-pink-100 text-pink-800',
        ];
    }
}
