<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Contracts\Enums\HasQuery;
use App\Contracts\Enums\HasTypes;
use App\Enums\Report\Type;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum ServicesHealth: string implements HasQuery, HasLabel, HasTypes
{
    use Arrayable;
    use Comparable;

    case SH01 = 'SH01';
    case SH02 = 'SH02';
    case SH03 = 'SH03';
    case SH04 = 'SH04';
    case SH05 = 'SH05';
    case SH06 = 'SH06';
    case SH07 = 'SH07';
    case SH08 = 'SH08';
    case SH09 = 'SH09';
    case SH10 = 'SH10';
    case SH11 = 'SH11';
    case SH12 = 'SH12';
    case SH13 = 'SH13';
    case SH14 = 'SH14';
    case SH15 = 'SH15';
    case SH16 = 'SH16';
    case SH17 = 'SH17';
    case SH18 = 'SH18';
    case SH19 = 'SH19';
    case SH20 = 'SH20';
    case SH21 = 'SH21';
    case SH22 = 'SH22';
    case SH23 = 'SH23';
    case SH24 = 'SH24';
    case SH25 = 'SH25';
    case SH26 = 'SH26';
    case SH27 = 'SH27';
    case SH28 = 'SH28';
    case SH29 = 'SH29';
    case SH30 = 'SH30';
    case SH31 = 'SH31';
    case SH32 = 'SH32';
    case SH33 = 'SH33';
    case SH34 = 'SH34';
    case SH35 = 'SH35';
    case SH36 = 'SH36';
    case SH37 = 'SH37';
    case SH38 = 'SH38';
    case SH39 = 'SH39';
    case SH40 = 'SH40';
    case SH41 = 'SH41';
    case SH42 = 'SH42';
    case SH43 = 'SH43';
    case SH44 = 'SH44';
    case SH45 = 'SH45';
    case SH46 = 'SH46';
    case SH47 = 'SH47';
    case SH48 = 'SH48';
    case SH49 = 'SH49';
    case SH50 = 'SH50';
    case SH51 = 'SH51';
    case SH52 = 'SH52';
    case SH53 = 'SH53';
    case SH54 = 'SH54';
    case SH55 = 'SH55';
    case SH56 = 'SH56';
    case SH57 = 'SH57';
    case SH58 = 'SH58';
    case SH59 = 'SH59';
    case SH60 = 'SH60';
    case SH61 = 'SH61';
    case SH62 = 'SH62';
    case SH63 = 'SH63';
    case SH64 = 'SH64';
    case SH65 = 'SH65';
    case SH66 = 'SH66';
    case SH67 = 'SH67';
    case SH68 = 'SH68';
    case SH69 = 'SH69';
    case SH70 = 'SH70';
    case SH71 = 'SH71';
    case SH72 = 'SH72';
    case SH73 = 'SH73';
    case SH74 = 'SH74';
    case SH75 = 'SH75';
    case SH76 = 'SH76';
    case SH77 = 'SH77';
    case SH78 = 'SH78';
    case SH79 = 'SH79';
    case SH80 = 'SH80';
    case SH81 = 'SH81';
    case SH82 = 'SH82';
    case SH83 = 'SH83';
    case SH84 = 'SH84';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SH01 => __('report.standard.indicator.services_health.SH01'),
            self::SH02 => __('report.standard.indicator.services_health.SH02'),
            self::SH03 => __('report.standard.indicator.services_health.SH03'),
            self::SH04 => __('report.standard.indicator.services_health.SH04'),
            self::SH05 => __('report.standard.indicator.services_health.SH05'),
            self::SH06 => __('report.standard.indicator.services_health.SH06'),
            self::SH07 => __('report.standard.indicator.services_health.SH07'),
            self::SH08 => __('report.standard.indicator.services_health.SH08'),
            self::SH09 => __('report.standard.indicator.services_health.SH09'),
            self::SH10 => __('report.standard.indicator.services_health.SH10'),
            self::SH11 => __('report.standard.indicator.services_health.SH11'),
            self::SH12 => __('report.standard.indicator.services_health.SH12'),
            self::SH13 => __('report.standard.indicator.services_health.SH13'),
            self::SH14 => __('report.standard.indicator.services_health.SH14'),
            self::SH15 => __('report.standard.indicator.services_health.SH15'),
            self::SH16 => __('report.standard.indicator.services_health.SH16'),
            self::SH17 => __('report.standard.indicator.services_health.SH17'),
            self::SH18 => __('report.standard.indicator.services_health.SH18'),
            self::SH19 => __('report.standard.indicator.services_health.SH19'),
            self::SH20 => __('report.standard.indicator.services_health.SH20'),
            self::SH21 => __('report.standard.indicator.services_health.SH21'),
            self::SH22 => __('report.standard.indicator.services_health.SH22'),
            self::SH23 => __('report.standard.indicator.services_health.SH23'),
            self::SH24 => __('report.standard.indicator.services_health.SH24'),
            self::SH25 => __('report.standard.indicator.services_health.SH25'),
            self::SH26 => __('report.standard.indicator.services_health.SH26'),
            self::SH27 => __('report.standard.indicator.services_health.SH27'),
            self::SH28 => __('report.standard.indicator.services_health.SH28'),
            self::SH29 => __('report.standard.indicator.services_health.SH29'),
            self::SH30 => __('report.standard.indicator.services_health.SH30'),
            self::SH31 => __('report.standard.indicator.services_health.SH31'),
            self::SH32 => __('report.standard.indicator.services_health.SH32'),
            self::SH33 => __('report.standard.indicator.services_health.SH33'),
            self::SH34 => __('report.standard.indicator.services_health.SH34'),
            self::SH35 => __('report.standard.indicator.services_health.SH35'),
            self::SH36 => __('report.standard.indicator.services_health.SH36'),
            self::SH37 => __('report.standard.indicator.services_health.SH37'),
            self::SH38 => __('report.standard.indicator.services_health.SH38'),
            self::SH39 => __('report.standard.indicator.services_health.SH39'),
            self::SH40 => __('report.standard.indicator.services_health.SH40'),
            self::SH41 => __('report.standard.indicator.services_health.SH41'),
            self::SH42 => __('report.standard.indicator.services_health.SH42'),
            self::SH43 => __('report.standard.indicator.services_health.SH43'),
            self::SH44 => __('report.standard.indicator.services_health.SH44'),
            self::SH45 => __('report.standard.indicator.services_health.SH45'),
            self::SH46 => __('report.standard.indicator.services_health.SH46'),
            self::SH47 => __('report.standard.indicator.services_health.SH47'),
            self::SH48 => __('report.standard.indicator.services_health.SH48'),
            self::SH49 => __('report.standard.indicator.services_health.SH49'),
            self::SH50 => __('report.standard.indicator.services_health.SH50'),
            self::SH51 => __('report.standard.indicator.services_health.SH51'),
            self::SH52 => __('report.standard.indicator.services_health.SH52'),
            self::SH53 => __('report.standard.indicator.services_health.SH53'),
            self::SH54 => __('report.standard.indicator.services_health.SH54'),
            self::SH55 => __('report.standard.indicator.services_health.SH55'),
            self::SH56 => __('report.standard.indicator.services_health.SH56'),
            self::SH57 => __('report.standard.indicator.services_health.SH57'),
            self::SH58 => __('report.standard.indicator.services_health.SH58'),
            self::SH59 => __('report.standard.indicator.services_health.SH59'),
            self::SH60 => __('report.standard.indicator.services_health.SH60'),
            self::SH61 => __('report.standard.indicator.services_health.SH61'),
            self::SH62 => __('report.standard.indicator.services_health.SH62'),
            self::SH63 => __('report.standard.indicator.services_health.SH63'),
            self::SH64 => __('report.standard.indicator.services_health.SH64'),
            self::SH65 => __('report.standard.indicator.services_health.SH65'),
            self::SH66 => __('report.standard.indicator.services_health.SH66'),
            self::SH67 => __('report.standard.indicator.services_health.SH67'),
            self::SH68 => __('report.standard.indicator.services_health.SH68'),
            self::SH69 => __('report.standard.indicator.services_health.SH69'),
            self::SH70 => __('report.standard.indicator.services_health.SH70'),
            self::SH71 => __('report.standard.indicator.services_health.SH71'),
            self::SH72 => __('report.standard.indicator.services_health.SH72'),
            self::SH73 => __('report.standard.indicator.services_health.SH73'),
            self::SH74 => __('report.standard.indicator.services_health.SH74'),
            self::SH75 => __('report.standard.indicator.services_health.SH75'),
            self::SH76 => __('report.standard.indicator.services_health.SH76'),
            self::SH77 => __('report.standard.indicator.services_health.SH77'),
            self::SH78 => __('report.standard.indicator.services_health.SH78'),
            self::SH79 => __('report.standard.indicator.services_health.SH79'),
            self::SH80 => __('report.standard.indicator.services_health.SH80'),
            self::SH81 => __('report.standard.indicator.services_health.SH81'),
            self::SH82 => __('report.standard.indicator.services_health.SH82'),
            self::SH83 => __('report.standard.indicator.services_health.SH83'),
            self::SH84 => __('report.standard.indicator.services_health.SH84'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\ServicesHealth\\{$this->value}";
    }

    public static function types(): array
    {
        return [
            Type::STATISTIC,
        ];
    }
}
