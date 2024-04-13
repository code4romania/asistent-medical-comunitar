<?php

declare(strict_types=1);

namespace App\Enums\Suspicion;

use App\Concerns;

enum Element: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    // case ELEMENT = 'element';

    protected function labelKeyPrefix(): ?string
    {
        return 'catagraphy.suspicion.element';
    }
}
