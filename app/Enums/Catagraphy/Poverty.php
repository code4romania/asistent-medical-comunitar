<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum Poverty: string
{
    use Arrayable;

    case VGS_01 = 'VGS_01';
    case VGS_02 = 'VGS_02';
    case VGS_99 = 'VGS_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.poverty';
    }
}
