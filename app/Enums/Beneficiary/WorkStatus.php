<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum WorkStatus: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case YES = 'yes';
    case NO = 'no';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::YES => __('beneficiary.work_status.yes'),
            self::NO => __('beneficiary.work_status.no'),
            self::OTHER => __('beneficiary.work_status.other'),
        };
    }
}
