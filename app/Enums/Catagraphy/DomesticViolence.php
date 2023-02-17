<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum DomesticViolence: string
{
    use Arrayable;

    case VFV_01 = 'VFV_01';
    case VFV_02 = 'VFV_02';
    case VFV_03 = 'VFV_03';
    case VFV_04 = 'VFV_04';
    case VFV_99 = 'VFV_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.domestic_violence';
    }
}
