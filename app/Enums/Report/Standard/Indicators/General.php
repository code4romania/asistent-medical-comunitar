<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Contracts\Enums\HasQuery;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum General: string implements HasQuery, HasLabel
{
    use Arrayable;
    use Comparable;

    case G01 = 'G01';
    case G02 = 'G02';
    case G03 = 'G03';
    case G04 = 'G04';
    case G05 = 'G05';
    case G06 = 'G06';
    case G07 = 'G07';
    case G08 = 'G08';
    case G09 = 'G09';
    case G10 = 'G10';
    case G11 = 'G11';
    case G12 = 'G12';
    case G13 = 'G13';
    case G14 = 'G14';
    case G15 = 'G15';
    case G16 = 'G16';
    case G17 = 'G17';
    case G18 = 'G18';
    case G19 = 'G19';
    case G20 = 'G20';
    case G21 = 'G21';
    case G22 = 'G22';
    case G23 = 'G23';
    case G24 = 'G24';
    case G25 = 'G25';
    case G26 = 'G26';
    case G27 = 'G27';
    case G28 = 'G28';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::G01 => __('report.standard.indicator.general.G01'),
            self::G02 => __('report.standard.indicator.general.G02'),
            self::G03 => __('report.standard.indicator.general.G03'),
            self::G04 => __('report.standard.indicator.general.G04'),
            self::G05 => __('report.standard.indicator.general.G05'),
            self::G06 => __('report.standard.indicator.general.G06'),
            self::G07 => __('report.standard.indicator.general.G07'),
            self::G08 => __('report.standard.indicator.general.G08'),
            self::G09 => __('report.standard.indicator.general.G09'),
            self::G10 => __('report.standard.indicator.general.G10'),
            self::G11 => __('report.standard.indicator.general.G11'),
            self::G12 => __('report.standard.indicator.general.G12'),
            self::G13 => __('report.standard.indicator.general.G13'),
            self::G14 => __('report.standard.indicator.general.G14'),
            self::G15 => __('report.standard.indicator.general.G15'),
            self::G16 => __('report.standard.indicator.general.G16'),
            self::G17 => __('report.standard.indicator.general.G17'),
            self::G18 => __('report.standard.indicator.general.G18'),
            self::G19 => __('report.standard.indicator.general.G19'),
            self::G20 => __('report.standard.indicator.general.G20'),
            self::G21 => __('report.standard.indicator.general.G21'),
            self::G22 => __('report.standard.indicator.general.G22'),
            self::G23 => __('report.standard.indicator.general.G23'),
            self::G24 => __('report.standard.indicator.general.G24'),
            self::G25 => __('report.standard.indicator.general.G25'),
            self::G26 => __('report.standard.indicator.general.G26'),
            self::G27 => __('report.standard.indicator.general.G27'),
            self::G28 => __('report.standard.indicator.general.G28'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\General\\{$this->value}";
    }
}
