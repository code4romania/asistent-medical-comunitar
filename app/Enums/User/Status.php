<?php

declare(strict_types=1);

namespace App\Enums\User;

use App\Concerns;

enum Status: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasColor;
    use Concerns\Enums\HasLabel;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case INVITED = 'invited';

    protected function labelKeyPrefix(): ?string
    {
        return 'user.status';
    }

    public static function colors(): array
    {
        return [
            'active' => 'success',
            'inactive' => 'bg-gray-100 text-gray-800',
            'invited' => 'warning',
        ];
    }
}
