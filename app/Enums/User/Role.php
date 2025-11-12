<?php

declare(strict_types=1);

namespace App\Enums\User;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case ADMIN = 'admin';
    case COORDINATOR = 'coordinator';
    case NURSE = 'nurse';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => __('user.role.admin'),
            self::COORDINATOR => __('user.role.coordinator'),
            self::NURSE => __('user.role.nurse'),
        };
    }
}
