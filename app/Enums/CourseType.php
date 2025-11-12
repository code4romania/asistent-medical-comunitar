<?php

declare(strict_types=1);

namespace App\Enums;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum CourseType: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case ONLINE = 'online';
    case OFFLINE = 'offline';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ONLINE => __('course.type.online'),
            self::OFFLINE => __('course.type.offline'),
            self::OTHER => __('course.type.other'),
        };
    }
}
