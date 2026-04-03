<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Contracts\Enums\HasQuery;
use App\Contracts\Enums\HasTypes;
use App\Enums\Report\Type;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Interventions: string implements HasQuery, HasLabel, HasTypes
{
    use Arrayable;
    use Comparable;

    case I01 = 'I01';
    case I02 = 'I02';
    case I03 = 'I03';
    case I04 = 'I04';
    case I05 = 'I05';
    case I06 = 'I06';
    case I07 = 'I07';
    case I08 = 'I08';
    case I09 = 'I09';
    case I10 = 'I10';
    case I11 = 'I11';
    case I12 = 'I12';
    case I13 = 'I13';
    case I14 = 'I14';
    case I15 = 'I15';
    case I16 = 'I16';
    case I17 = 'I17';
    case I18 = 'I18';
    case I19 = 'I19';
    case I20 = 'I20';
    case I21 = 'I21';
    case I22 = 'I22';
    case I23 = 'I23';
    case I24 = 'I24';
    case I25 = 'I25';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::I01 => __('report.standard.indicator.interventions.I01'),
            self::I02 => __('report.standard.indicator.interventions.I02'),
            self::I03 => __('report.standard.indicator.interventions.I03'),
            self::I04 => __('report.standard.indicator.interventions.I04'),
            self::I05 => __('report.standard.indicator.interventions.I05'),
            self::I06 => __('report.standard.indicator.interventions.I06'),
            self::I07 => __('report.standard.indicator.interventions.I07'),
            self::I08 => __('report.standard.indicator.interventions.I08'),
            self::I09 => __('report.standard.indicator.interventions.I09'),
            self::I10 => __('report.standard.indicator.interventions.I10'),
            self::I11 => __('report.standard.indicator.interventions.I11'),
            self::I12 => __('report.standard.indicator.interventions.I12'),
            self::I13 => __('report.standard.indicator.interventions.I13'),
            self::I14 => __('report.standard.indicator.interventions.I14'),
            self::I15 => __('report.standard.indicator.interventions.I15'),
            self::I16 => __('report.standard.indicator.interventions.I16'),
            self::I17 => __('report.standard.indicator.interventions.I17'),
            self::I18 => __('report.standard.indicator.interventions.I18'),
            self::I19 => __('report.standard.indicator.interventions.I19'),
            self::I20 => __('report.standard.indicator.interventions.I20'),
            self::I21 => __('report.standard.indicator.interventions.I21'),
            self::I22 => __('report.standard.indicator.interventions.I22'),
            self::I23 => __('report.standard.indicator.interventions.I23'),
            self::I24 => __('report.standard.indicator.interventions.I24'),
            self::I25 => __('report.standard.indicator.interventions.I25'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\Interventions\\{$this->value}";
    }

    public static function types(): array
    {
        return [
            Type::LIST,
            Type::STATISTIC,
        ];
    }
}
