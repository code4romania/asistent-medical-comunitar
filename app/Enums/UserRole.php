<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;

enum UserRole: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;

    case ADMIN = 'admin';
    case COORDINATOR = 'coordinator';
    case MEDIATOR = 'mediator';
    case NURSE = 'nurse';
}
