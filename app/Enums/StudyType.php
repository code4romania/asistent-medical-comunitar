<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum StudyType: string
{
    use ArrayableEnum;

    case secondary = 'secondary';
    case postSecondary = 'post_secondary';
    case university = 'university';
    case postGrad = 'post_grad';
    case other = 'other';

    protected function translationKeyPrefix(): ?string
    {
        return 'user.profile.study';
    }
}
