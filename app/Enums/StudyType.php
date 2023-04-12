<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;

enum StudyType: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;

    case SECONDARY = 'secondary';
    case POSTSECONDARY = 'postsecondary';
    case UNIVERSITY = 'university';
    case POSTGRADUATE = 'postgraduate';
    case OTHER = 'other';

    protected function translationKeyPrefix(): ?string
    {
        return 'study.type';
    }
}
