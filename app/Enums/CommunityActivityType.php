<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;

enum CommunityActivityType: string
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
