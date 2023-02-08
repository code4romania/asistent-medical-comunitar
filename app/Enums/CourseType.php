<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;

enum CourseType: string
{
    use Arrayable;

    case ONLINE = 'online';
    case OFFLINE = 'offline';
    case OTHER = 'other';

    protected function translationKeyPrefix(): ?string
    {
        return 'course.type';
    }
}
