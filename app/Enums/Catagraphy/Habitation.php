<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum Habitation: string
{
    use Arrayable;

    case VLP_03 = 'VLP_03';
    case VLP_01 = 'VLP_01';
    case VLP_02 = 'VLP_02';
    case VLP_99 = 'VLP_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.habitation';
    }
}
