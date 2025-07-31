<?php

declare(strict_types=1);

namespace App\Enums\CommunityActivity;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Campaign: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case NATIONAL = 'national';
    case LOCAL = 'local';
    case ACTIVITY = 'activity';
    case INTERVENTION = 'intervention';
    case SCREENING = 'screening';
    case EPIDEM_TRIAGE = 'epidem_triage';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NATIONAL => __('community_activity.campaign.national'),
            self::LOCAL => __('community_activity.campaign.local'),
            self::ACTIVITY => __('community_activity.campaign.activity'),
            self::INTERVENTION => __('community_activity.campaign.intervention'),
            self::SCREENING => __('community_activity.campaign.screening'),
            self::EPIDEM_TRIAGE => __('community_activity.campaign.epidem_triage'),
        };
    }
}
