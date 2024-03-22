<?php

declare(strict_types=1);

namespace App\Enums\CommunityActivity;

use App\Concerns;

enum Type: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case CAMPAIGN = 'campaign';
    case ADMINISTRATIVE = 'administrative';

    protected function labelKeyPrefix(): ?string
    {
        return 'community_activity.type';
    }
}
