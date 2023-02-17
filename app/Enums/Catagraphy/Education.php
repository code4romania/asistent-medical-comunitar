<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum Education: string
{
    use Arrayable;

    case VEC_01 = 'VEC_01';
    case VEC_02 = 'VEC_02';
    case VEC_03 = 'VEC_03';
    case VEC_04 = 'VEC_04';
    case VEC_05 = 'VEC_05';
    case VEC_06 = 'VEC_06';
    case VEC_07 = 'VEC_07';
    case VEA_01 = 'VEA_01';
    case VECA_99 = 'VECA_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.education';
    }
}
