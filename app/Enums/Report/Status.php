<?php

declare(strict_types=1);

namespace App\Enums\Report;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    use Arrayable;
    use Comparable;

    case PENDING = 'pending';
    case FINISHED = 'finished';
    case FAILED = 'failed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => __('report.status.pending'),
            self::FINISHED => __('report.status.finished'),
            self::FAILED => __('report.status.failed'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => Color::Blue,
            self::FINISHED => 'Color::Green',
            self::FAILED => Color::Red,
        };
    }
}
