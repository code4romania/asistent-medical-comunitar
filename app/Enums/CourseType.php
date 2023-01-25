<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum CourseType: string
{
    use ArrayableEnum;

    case online = 'online';
    case offline = 'offline';
    case other = 'other';

    protected function translationKeyPrefix(): ?string
    {
        return 'course.type';
    }
}
