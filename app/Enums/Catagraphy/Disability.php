<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum Disability: string
{
    use Arrayable;

    case VDH_01 = 'VDH_01';
    case VDH_02 = 'VDH_02';
    case VDH_99 = 'VDH_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.disability';
    }
}
