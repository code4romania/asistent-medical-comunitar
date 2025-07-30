<?php

declare(strict_types=1);

namespace App\Enums\CommunityActivity;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Administrative: string
{
    use Arrayable;
    use Comparable;
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
