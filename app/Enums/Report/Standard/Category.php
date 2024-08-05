<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard;

use App\Concerns;

enum Category: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case GENERAL = 'general';
    case PREGNANT = 'pregnant';
    case CHILD = 'child';
    case RARE_DISEASE = 'rare_disease';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.standard.category';
    }

    public function indicators(): string
    {
        return match ($this) {
            self::GENERAL => Indicators\General::class,
            self::PREGNANT => Indicators\Pregnant::class,
            self::CHILD => Indicators\Child::class,
            self::RARE_DISEASE => Indicators\RareDisease::class,
        };
    }
}
