<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum Family: string
{
    use Arrayable;

    case VFC_01 = 'VFC_01';
    case VFC_02 = 'VFC_02';
    case VFC_03 = 'VFC_03';
    case VFC_04 = 'VFC_04';
    case VFC_05 = 'VFC_05';
    case VFC_06 = 'VFC_06';
    case VFA_01 = 'VFA_01';
    case VFA_02 = 'VFA_02';
    case VFCA_99 = 'VFCA_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.family';
    }
}
