<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum Income: string
{
    use Arrayable;

    case VSV_01 = 'VSV_01';
    case VSV_02 = 'VSV_02';
    case VSV_99 = 'VSV_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.income';
    }
}
