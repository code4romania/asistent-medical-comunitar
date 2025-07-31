<?php

declare(strict_types=1);

namespace App\Enums\Report\Segment;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Age: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case VCV_01 = 'VCV_01';
    case VCV_02 = 'VCV_02';
    case VCV_03 = 'VCV_03';
    case VCV_04 = 'VCV_04';
    case VCV_05 = 'VCV_05';
    case VCV_06 = 'VCV_06';
    case TOTAL = 'total';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::VCV_01 => __('report.segment.value.age.VCV_01'),
            self::VCV_02 => __('report.segment.value.age.VCV_02'),
            self::VCV_03 => __('report.segment.value.age.VCV_03'),
            self::VCV_04 => __('report.segment.value.age.VCV_04'),
            self::VCV_05 => __('report.segment.value.age.VCV_05'),
            self::VCV_06 => __('report.segment.value.age.VCV_06'),
            self::TOTAL => __('report.segment.value.age.total'),
        };
    }
}
