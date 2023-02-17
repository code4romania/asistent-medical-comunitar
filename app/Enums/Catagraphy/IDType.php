<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum IDType: string
{
    use Arrayable;

    case VAI_01 = 'VAI_01';
    case VAI_02 = 'VAI_02';
    case VAI_99 = 'VAI_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.id_type';
    }
}
