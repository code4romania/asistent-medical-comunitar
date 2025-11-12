<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum ReasonRemoved: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case DECEASED_HOME = 'deceased_home';
    case DECEASED_HOSPITAL = 'deceased_hospital';
    case RELOCATED_CITY = 'relocated_city';
    case RELOCATED_ABROAD = 'relocated_abroad';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DECEASED_HOME => __('beneficiary.reason_removed.deceased_home'),
            self::DECEASED_HOSPITAL => __('beneficiary.reason_removed.deceased_hospital'),
            self::RELOCATED_CITY => __('beneficiary.reason_removed.relocated_city'),
            self::RELOCATED_ABROAD => __('beneficiary.reason_removed.relocated_abroad'),
            self::OTHER => __('beneficiary.reason_removed.other'),
        };
    }
}
