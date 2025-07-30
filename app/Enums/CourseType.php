<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum CourseType: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case ONLINE = 'online';
    case OFFLINE = 'offline';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'course.type';
    }
}
