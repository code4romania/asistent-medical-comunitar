<?php

declare(strict_types=1);

namespace App\Enums\Report\Segment;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';
    case TOTAL = 'total';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.segment.value.gender';
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FEMALE => __('report.segment.value.gender.female'),
            self::MALE => __('report.segment.value.gender.male'),
            self::OTHER => __('report.segment.value.gender.other'),
            self::TOTAL => __('report.segment.value.gender.total'),
        };
    }
}
