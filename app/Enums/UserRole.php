<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;

enum UserRole: string
{
    use Arrayable;

    case ADMIN = 'admin';
    case NURSE = 'nurse';
}
