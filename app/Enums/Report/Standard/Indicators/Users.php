<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Contracts\Enums\HasQuery;
use App\Contracts\Enums\HasTypes;
use App\Enums\Report\Type;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Users: string implements HasQuery, HasLabel, HasTypes
{
    use Arrayable;
    use Comparable;

    case U01 = 'U01';
    case U02 = 'U02';
    case U03 = 'U03';
    case U04 = 'U04';
    case U05 = 'U05';
    case U06 = 'U06';
    case U07 = 'U07';
    case U08 = 'U08';
    case U09 = 'U09';
    case U10 = 'U10';
    case U11 = 'U11';
    case U12 = 'U12';
    case U13 = 'U13';
    case U14 = 'U14';
    case U15 = 'U15';
    case U16 = 'U16';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::U01 => __('report.standard.indicator.users.U01'),
            self::U02 => __('report.standard.indicator.users.U02'),
            self::U03 => __('report.standard.indicator.users.U03'),
            self::U04 => __('report.standard.indicator.users.U04'),
            self::U05 => __('report.standard.indicator.users.U05'),
            self::U06 => __('report.standard.indicator.users.U06'),
            self::U07 => __('report.standard.indicator.users.U07'),
            self::U08 => __('report.standard.indicator.users.U08'),
            self::U09 => __('report.standard.indicator.users.U09'),
            self::U10 => __('report.standard.indicator.users.U10'),
            self::U11 => __('report.standard.indicator.users.U11'),
            self::U12 => __('report.standard.indicator.users.U12'),
            self::U13 => __('report.standard.indicator.users.U13'),
            self::U14 => __('report.standard.indicator.users.U14'),
            self::U15 => __('report.standard.indicator.users.U15'),
            self::U16 => __('report.standard.indicator.users.U16'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\Users\\{$this->value}";
    }

    public static function types(): array
    {
        return [
            Type::STATISTIC,
        ];
    }
}
