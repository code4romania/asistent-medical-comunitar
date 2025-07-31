<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasColor, HasLabel
{
    use Arrayable;
    use Comparable;

    case REGULAR = 'regular';
    case OCASIONAL = 'ocasional';

    protected function labelKeyPrefix(): ?string
    {
        return 'beneficiary.type';
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::REGULAR => __('beneficiary.type.regular'),
            self::OCASIONAL => __('beneficiary.type.ocasional'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::REGULAR => 'primary',
            self::OCASIONAL => Color::Violet,
        };
    }

    public static function colors(): array
    {
        return [
            'regular' => 'primary',
            'ocasional' => 'bg-violet-100 text-violet-800',
        ];
    }
}
