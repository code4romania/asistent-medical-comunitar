<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    use Arrayable;
    use Comparable;

    case REGISTERED = 'registered';
    case CATAGRAPHED = 'catagraphed';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REMOVED = 'removed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::REGISTERED => __('beneficiary.status.registered'),
            self::CATAGRAPHED => __('beneficiary.status.catagraphed'),
            self::ACTIVE => __('beneficiary.status.active'),
            self::INACTIVE => __('beneficiary.status.inactive'),
            self::REMOVED => __('beneficiary.status.removed'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::REGISTERED => Color::Amber,
            self::CATAGRAPHED => Color::Blue,
            self::ACTIVE => Color::Emerald,
            self::INACTIVE => Color::Gray,
            self::REMOVED => Color::Pink,
        };
    }
}
