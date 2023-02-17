<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum AgeCategory: string
{
    use Arrayable;

    case VCV_01 = 'VCV_01';
    case VCV_02 = 'VCV_02';
    case VCV_03 = 'VCV_03';
    case VCV_04 = 'VCV_04';
    case VCV_05 = 'VCV_05';
    case VCV_06 = 'VCV_06';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.age_category';
    }
}
