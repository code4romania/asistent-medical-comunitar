<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum StudyType: string
{
    use Arrayable;
    use Comparable;
    use Concerns\Enums\HasLabel;

    case SECONDARY = 'secondary';
    case POSTSECONDARY = 'postsecondary';
    case UNIVERSITY = 'university';
    case POSTGRADUATE = 'postgraduate';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'study.type';
    }
}
