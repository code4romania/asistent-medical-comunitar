<?php

declare(strict_types=1);

namespace App\Enums\CommunityActivity;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum OutsideWorkingHours: int implements HasLabel
{
    use Arrayable;
    use Comparable;

    case YES = 1;
    case NO = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::YES => __('community_activity.hour.outside_working_hours'),
            self::NO => __('community_activity.hour.within_working_hours'),
        };
    }
}
