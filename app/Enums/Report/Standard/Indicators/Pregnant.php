<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Contracts\Enums\HasQuery;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Pregnant: string implements HasQuery, HasLabel
{
    use Arrayable;
    use Comparable;

    case P01 = 'P01';
    case P02 = 'P02';
    case P03 = 'P03';
    case P04 = 'P04';
    case P05 = 'P05';
    case P06 = 'P06';
    case P07 = 'P07';
    case P08 = 'P08';
    case P09 = 'P09';
    case P10 = 'P10';
    case P11 = 'P11';
    case P12 = 'P12';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::P01 => __('report.standard.indicator.pregnant.P01'),
            self::P02 => __('report.standard.indicator.pregnant.P02'),
            self::P03 => __('report.standard.indicator.pregnant.P03'),
            self::P04 => __('report.standard.indicator.pregnant.P04'),
            self::P05 => __('report.standard.indicator.pregnant.P05'),
            self::P06 => __('report.standard.indicator.pregnant.P06'),
            self::P07 => __('report.standard.indicator.pregnant.P07'),
            self::P08 => __('report.standard.indicator.pregnant.P08'),
            self::P09 => __('report.standard.indicator.pregnant.P09'),
            self::P10 => __('report.standard.indicator.pregnant.P10'),
            self::P11 => __('report.standard.indicator.pregnant.P11'),
            self::P12 => __('report.standard.indicator.pregnant.P12'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\Pregnant\\{$this->value}";
    }
}
