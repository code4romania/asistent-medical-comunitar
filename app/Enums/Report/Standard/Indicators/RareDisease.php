<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Contracts\Enums\HasQuery;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum RareDisease: string implements HasQuery, HasLabel
{
    use Arrayable;
    use Comparable;

    case RD01 = 'RD01';
    case RD02 = 'RD02';
    case RD03 = 'RD03';
    case RD04 = 'RD04';
    case RD05 = 'RD05';
    case RD06 = 'RD06';
    case RD07 = 'RD07';
    case RD08 = 'RD08';
    case RD09 = 'RD09';
    case RD10 = 'RD10';
    case RD11 = 'RD11';
    case RD12 = 'RD12';
    case RD13 = 'RD13';
    case RD14 = 'RD14';
    case RD15 = 'RD15';
    case RD16 = 'RD16';
    case RD17 = 'RD17';
    case RD18 = 'RD18';
    case RD19 = 'RD19';
    case RD20 = 'RD20';
    case RD21 = 'RD21';
    case RD22 = 'RD22';
    case RD23 = 'RD23';
    case RD24 = 'RD24';
    case RD25 = 'RD25';
    case RD26 = 'RD26';
    case RD27 = 'RD27';
    case RD28 = 'RD28';
    case RD29 = 'RD29';
    case RD30 = 'RD30';
    case RD31 = 'RD31';
    case RD32 = 'RD32';
    case RD33 = 'RD33';
    case RD34 = 'RD34';
    case RD35 = 'RD35';
    case RD36 = 'RD36';
    case RD37 = 'RD37';
    case RD38 = 'RD38';
    case RD39 = 'RD39';
    case RD40 = 'RD40';
    case RD41 = 'RD41';
    case RD42 = 'RD42';
    case RD43 = 'RD43';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::RD01 => __('report.standard.indicator.rare_disease.RD01'),
            self::RD02 => __('report.standard.indicator.rare_disease.RD02'),
            self::RD03 => __('report.standard.indicator.rare_disease.RD03'),
            self::RD04 => __('report.standard.indicator.rare_disease.RD04'),
            self::RD05 => __('report.standard.indicator.rare_disease.RD05'),
            self::RD06 => __('report.standard.indicator.rare_disease.RD06'),
            self::RD07 => __('report.standard.indicator.rare_disease.RD07'),
            self::RD08 => __('report.standard.indicator.rare_disease.RD08'),
            self::RD09 => __('report.standard.indicator.rare_disease.RD09'),
            self::RD10 => __('report.standard.indicator.rare_disease.RD10'),
            self::RD11 => __('report.standard.indicator.rare_disease.RD11'),
            self::RD12 => __('report.standard.indicator.rare_disease.RD12'),
            self::RD13 => __('report.standard.indicator.rare_disease.RD13'),
            self::RD14 => __('report.standard.indicator.rare_disease.RD14'),
            self::RD15 => __('report.standard.indicator.rare_disease.RD15'),
            self::RD16 => __('report.standard.indicator.rare_disease.RD16'),
            self::RD17 => __('report.standard.indicator.rare_disease.RD17'),
            self::RD18 => __('report.standard.indicator.rare_disease.RD18'),
            self::RD19 => __('report.standard.indicator.rare_disease.RD19'),
            self::RD20 => __('report.standard.indicator.rare_disease.RD20'),
            self::RD21 => __('report.standard.indicator.rare_disease.RD21'),
            self::RD22 => __('report.standard.indicator.rare_disease.RD22'),
            self::RD23 => __('report.standard.indicator.rare_disease.RD23'),
            self::RD24 => __('report.standard.indicator.rare_disease.RD24'),
            self::RD25 => __('report.standard.indicator.rare_disease.RD25'),
            self::RD26 => __('report.standard.indicator.rare_disease.RD26'),
            self::RD27 => __('report.standard.indicator.rare_disease.RD27'),
            self::RD28 => __('report.standard.indicator.rare_disease.RD28'),
            self::RD29 => __('report.standard.indicator.rare_disease.RD29'),
            self::RD30 => __('report.standard.indicator.rare_disease.RD30'),
            self::RD31 => __('report.standard.indicator.rare_disease.RD31'),
            self::RD32 => __('report.standard.indicator.rare_disease.RD32'),
            self::RD33 => __('report.standard.indicator.rare_disease.RD33'),
            self::RD34 => __('report.standard.indicator.rare_disease.RD34'),
            self::RD35 => __('report.standard.indicator.rare_disease.RD35'),
            self::RD36 => __('report.standard.indicator.rare_disease.RD36'),
            self::RD37 => __('report.standard.indicator.rare_disease.RD37'),
            self::RD38 => __('report.standard.indicator.rare_disease.RD38'),
            self::RD39 => __('report.standard.indicator.rare_disease.RD39'),
            self::RD40 => __('report.standard.indicator.rare_disease.RD40'),
            self::RD41 => __('report.standard.indicator.rare_disease.RD41'),
            self::RD42 => __('report.standard.indicator.rare_disease.RD42'),
            self::RD43 => __('report.standard.indicator.rare_disease.RD43'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\RareDisease\\{$this->value}";
    }
}
