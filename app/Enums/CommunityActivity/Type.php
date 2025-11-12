<?php

declare(strict_types=1);

namespace App\Enums\CommunityActivity;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case CAMPAIGN = 'campaign';
    case ADMINISTRATIVE = 'administrative';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CAMPAIGN => __('community_activity.type.campaign'),
            self::ADMINISTRATIVE => __('community_activity.type.administrative'),
        };
    }
}
