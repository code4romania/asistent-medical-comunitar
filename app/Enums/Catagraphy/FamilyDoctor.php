<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum FamilyDoctor: string
{
    use Arrayable;

    case VSA_02 = 'VSA_02';
    case VSA_99 = 'VSA_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.family_doctor';
    }
}
