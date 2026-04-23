<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Contracts\Enums\HasColumns;
use App\Contracts\Enums\HasQuery;
use App\Contracts\Enums\HasTypes;
use App\Enums\Report\Type;
use App\Enums\User\Role;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Activity: string implements HasQuery, HasLabel, HasTypes, HasColumns
{
    use Arrayable;
    use Comparable;

    case A01 = 'A01';
    case A02 = 'A02';
    case A03 = 'A03';
    case A04 = 'A04';
    case A05 = 'A05';
    case A06 = 'A06';
    case A07 = 'A07';
    case A08 = 'A08';
    case A09 = 'A09';
    case A10 = 'A10';
    case A11 = 'A11';
    case A12 = 'A12';
    case A13 = 'A13';
    case A14 = 'A14';
    case A15 = 'A15';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::A01 => __('report.standard.indicator.activity.A01'),
            self::A02 => __('report.standard.indicator.activity.A02'),
            self::A03 => __('report.standard.indicator.activity.A03'),
            self::A04 => __('report.standard.indicator.activity.A04'),
            self::A05 => __('report.standard.indicator.activity.A05'),
            self::A06 => __('report.standard.indicator.activity.A06'),
            self::A07 => __('report.standard.indicator.activity.A07'),
            self::A08 => __('report.standard.indicator.activity.A08'),
            self::A09 => __('report.standard.indicator.activity.A09'),
            self::A10 => __('report.standard.indicator.activity.A10'),
            self::A11 => __('report.standard.indicator.activity.A11'),
            self::A12 => __('report.standard.indicator.activity.A12'),
            self::A13 => __('report.standard.indicator.activity.A13'),
            self::A14 => __('report.standard.indicator.activity.A14'),
            self::A15 => __('report.standard.indicator.activity.A15'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\Activity\\{$this->value}";
    }

    public static function types(): array
    {
        return [
            Type::STATISTIC,
        ];
    }

    public static function columns(Type $type, Role $role): array
    {
        return [];
    }
}
