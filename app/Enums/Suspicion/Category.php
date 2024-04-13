<?php

declare(strict_types=1);

namespace App\Enums\Suspicion;

use App\Concerns;

enum Category: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case CHRONIC = 'chronic';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'catagraphy.suspicion.category';
    }
}
