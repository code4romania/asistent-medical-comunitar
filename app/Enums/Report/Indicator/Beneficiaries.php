<?php

declare(strict_types=1);

namespace App\Enums\Report\Indicator;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Beneficiaries: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case TOTAL = 'total';
    case REGISTERED = 'registered';
    case CATAGRAPHED = 'catagraphed';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REMOVED = 'removed';
    // case OCASIONAL = 'ocasional';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TOTAL => __('report.indicator.value.beneficiaries.total'),
            self::REGISTERED => __('report.indicator.value.beneficiaries.registered'),
            self::CATAGRAPHED => __('report.indicator.value.beneficiaries.catagraphed'),
            self::ACTIVE => __('report.indicator.value.beneficiaries.active'),
            self::INACTIVE => __('report.indicator.value.beneficiaries.inactive'),
            self::REMOVED => __('report.indicator.value.beneficiaries.removed'),
            // self::OCASIONAL => __('report.indicator.value.beneficiaries.ocasional'),
        };
    }
}
