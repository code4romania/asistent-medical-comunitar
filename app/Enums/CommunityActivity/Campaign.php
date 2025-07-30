<?php

declare(strict_types=1);

namespace App\Enums\CommunityActivity;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Campaign: string
{
    use Arrayable;
    use Comparable;
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
