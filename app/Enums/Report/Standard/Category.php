<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum Category: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case GENERAL = 'general';
    case PREGNANT = 'pregnant';
    case CHILD = 'child';
    case RARE_DISEASE = 'rare_disease';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.standard.category';
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
