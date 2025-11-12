<?php

declare(strict_types=1);

namespace App\Enums\Intervention;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    use Arrayable;
    use Comparable;

    case PLANNED = 'planned';
    case REALIZED = 'realized';
    case UNREALIZED = 'unrealized';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PLANNED => __('intervention.status.planned'),
            self::REALIZED => __('intervention.status.realized'),
            self::UNREALIZED => __('intervention.status.unrealized'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PLANNED => Color::Blue,
            self::REALIZED => Color::Emerald,
            self::UNREALIZED => Color::Pink,
        };
    }
}
