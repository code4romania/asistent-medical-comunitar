<?php

declare(strict_types=1);

namespace App\Enums\User;

use App\Contracts\Enums\CanBeFiltered;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasLabel, CanBeFiltered
{
    use Arrayable;
    use Comparable;

    case ADMIN = 'admin';
    case COORDINATOR = 'coordinator';
    case NURSE = 'nurse';
    case MEDIATOR = 'mediator';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => __('user.role.admin'),
            self::COORDINATOR => __('user.role.coordinator'),
            self::NURSE => __('user.role.nurse'),
            self::MEDIATOR => __('user.role.mediator'),
        };
    }

    public function isVisible(): bool
    {
        return match ($this) {
            self::ADMIN, self::COORDINATOR => auth()->user()->isAdmin(),
            self::NURSE, self::MEDIATOR => auth()->user()->isAdmin() || auth()->user()->isCoordinator(),
        };
    }
}
