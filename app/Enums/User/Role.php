<?php

declare(strict_types=1);

namespace App\Enums\User;

use App\Concerns;

enum Role: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;

    case ADMIN = 'admin';
    case COORDINATOR = 'coordinator';
    case NURSE = 'nurse';
}
