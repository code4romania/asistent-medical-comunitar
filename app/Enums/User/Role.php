<?php

declare(strict_types=1);

namespace App\Enums\User;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Role: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case ADMIN = 'admin';
    case COORDINATOR = 'coordinator';
    case NURSE = 'nurse';

    protected function labelKeyPrefix(): ?string
    {
        return 'user.role';
    }
}
