<?php

declare(strict_types=1);

namespace App\Enums\User;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    use Arrayable;
    use Comparable;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case INVITED = 'invited';

    protected function labelKeyPrefix(): ?string
    {
        return 'user.status';
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ACTIVE => __('user.status.active'),
            self::INACTIVE => __('user.status.inactive'),
            self::INVITED => __('user.status.invited'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ACTIVE => Color::Green,
            self::INACTIVE => Color::Gray,
            self::INVITED => Color::Amber,
        };
    }
}
