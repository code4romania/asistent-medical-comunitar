<?php

declare(strict_types=1);

namespace App\Enums\Catagraphy;

use App\Concerns\Enums\Arrayable;

enum SocialHealthInsurance: string
{
    use Arrayable;

    case VSA_01 = 'VSA_01';
    case VSA_98 = 'VSA_98';
    case VSA_99 = 'VSA_99';

    protected function translationKeyPrefix(): ?string
    {
        return 'catagraphy.social_health_insurance';
    }
}
