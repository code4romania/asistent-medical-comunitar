<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Category: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case GENERAL = 'general';
    case PREGNANT = 'pregnant';
    case CHILD = 'child';
    case RARE_DISEASE = 'rare_disease';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GENERAL => __('report.standard.category.general'),
            self::PREGNANT => __('report.standard.category.pregnant'),
            self::CHILD => __('report.standard.category.child'),
            self::RARE_DISEASE => __('report.standard.category.rare_disease'),
        };
    }

    public function indicator(): string
    {
        return match ($this) {
            self::GENERAL => Indicators\General::class,
            self::PREGNANT => Indicators\Pregnant::class,
            self::CHILD => Indicators\Child::class,
            self::RARE_DISEASE => Indicators\RareDisease::class,
        };
    }
}
