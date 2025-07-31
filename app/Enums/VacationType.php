<?php

declare(strict_types=1);

namespace App\Enums;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum VacationType: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case MEDICAL = 'medical';
    case REST = 'rest';
    case CHILD = 'child';
    case special = 'special';
    case BLOOD_DONATION = 'blood_donation';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MEDICAL => __('vacation.type.medical'),
            self::REST => __('vacation.type.rest'),
            self::CHILD => __('vacation.type.child'),
            self::special => __('vacation.type.special'),
            self::BLOOD_DONATION => __('vacation.type.blood_donation'),
            self::OTHER => __('vacation.type.other'),
        };
    }
}
