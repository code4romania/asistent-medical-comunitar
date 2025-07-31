<?php

declare(strict_types=1);

namespace App\Enums;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FEMALE => __('gender.female'),
            self::MALE => __('gender.male'),
            self::OTHER => __('gender.other'),
        };
    }
}
