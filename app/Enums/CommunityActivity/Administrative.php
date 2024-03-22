<?php

declare(strict_types=1);

namespace App\Enums\CommunityActivity;

use App\Concerns;

enum Administrative: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case SOFTWARE = 'software';
    case MEETING = 'meeting';
    case TRAINING = 'training';
    case PLANNING = 'planning';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'community_activity.administrative';
    }
}
