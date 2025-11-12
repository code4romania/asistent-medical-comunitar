<?php

declare(strict_types=1);

namespace App\Enums;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum StudyType: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case SECONDARY = 'secondary';
    case POSTSECONDARY = 'postsecondary';
    case UNIVERSITY = 'university';
    case POSTGRADUATE = 'postgraduate';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SECONDARY => __('study.type.secondary'),
            self::POSTSECONDARY => __('study.type.postsecondary'),
            self::UNIVERSITY => __('study.type.university'),
            self::POSTGRADUATE => __('study.type.postgraduate'),
            self::OTHER => __('study.type.other'),
        };
    }
}
