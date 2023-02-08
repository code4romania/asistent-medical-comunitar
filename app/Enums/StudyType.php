<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;

enum StudyType: string
{
    use Arrayable;

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
