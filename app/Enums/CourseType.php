<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum CourseType: string
{
    use ArrayableEnum;

    case ONLINE = 'online';
    case OFFLINE = 'offline';
    case OTHER = 'other';

    protected function translationKeyPrefix(): ?string
    {
        return 'course.type';
    }
}
