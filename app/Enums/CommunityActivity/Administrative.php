<?php

declare(strict_types=1);

namespace App\Enums\CommunityActivity;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Administrative: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case SOFTWARE = 'software';
    case MEETING = 'meeting';
    case TRAINING = 'training';
    case PLANNING = 'planning';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SOFTWARE => __('community_activity.administrative.software'),
            self::MEETING => __('community_activity.administrative.meeting'),
            self::TRAINING => __('community_activity.administrative.training'),
            self::PLANNING => __('community_activity.administrative.planning'),
            self::OTHER => __('community_activity.administrative.other'),
        };
    }
}
