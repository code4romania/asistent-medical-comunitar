<?php

declare(strict_types=1);

namespace App\Enums\CommunityActivity;

use App\Concerns;

enum Campaign: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case NATIONAL = 'national';
    case LOCAL = 'local';
    case ACTIVITY = 'activity';
    case INTERVENTION = 'intervention';
    case SCREENING = 'screening';
    case EPIDEM_TRIAGE = 'epidem_triage';

    protected function labelKeyPrefix(): ?string
    {
        return 'community_activity.campaign';
    }
}
