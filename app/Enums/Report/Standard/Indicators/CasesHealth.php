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

enum CasesHealth: string implements HasQuery, HasLabel, HasTypes, HasColumns
{
    use Arrayable;
    use Comparable;

    case CH01 = 'CH01';
    case CH02 = 'CH02';
    case CH03 = 'CH03';
    case CH04 = 'CH04';
    case CH05 = 'CH05';
    case CH06 = 'CH06';
    case CH07 = 'CH07';
    case CH08 = 'CH08';
    case CH09 = 'CH09';
    case CH10 = 'CH10';
    case CH11 = 'CH11';
    case CH12 = 'CH12';
    case CH13 = 'CH13';
    case CH14 = 'CH14';
    case CH15 = 'CH15';
    case CH16 = 'CH16';
    case CH17 = 'CH17';
    case CH18 = 'CH18';
    case CH19 = 'CH19';
    case CH20 = 'CH20';
    case CH21 = 'CH21';
    case CH22 = 'CH22';
    case CH23 = 'CH23';
    case CH24 = 'CH24';
    case CH25 = 'CH25';
    case CH26 = 'CH26';
    case CH27 = 'CH27';
    case CH28 = 'CH28';
    case CH29 = 'CH29';
    case CH30 = 'CH30';
    case CH31 = 'CH31';
    case CH32 = 'CH32';
    case CH33 = 'CH33';
    case CH34 = 'CH34';
    case CH35 = 'CH35';
    case CH36 = 'CH36';
    case CH37 = 'CH37';
    case CH38 = 'CH38';
    case CH39 = 'CH39';
    case CH40 = 'CH40';
    case CH41 = 'CH41';
    case CH42 = 'CH42';
    case CH43 = 'CH43';
    case CH44 = 'CH44';
    case CH45 = 'CH45';
    case CH46 = 'CH46';
    case CH47 = 'CH47';
    case CH48 = 'CH48';
    case CH49 = 'CH49';
    case CH50 = 'CH50';
    case CH51 = 'CH51';
    case CH52 = 'CH52';
    case CH53 = 'CH53';
    case CH54 = 'CH54';
    case CH55 = 'CH55';
    case CH56 = 'CH56';
    case CH57 = 'CH57';
    case CH58 = 'CH58';
    case CH59 = 'CH59';
    case CH60 = 'CH60';
    case CH61 = 'CH61';
    case CH62 = 'CH62';
    case CH63 = 'CH63';
    case CH64 = 'CH64';
    case CH65 = 'CH65';
    case CH66 = 'CH66';
    case CH67 = 'CH67';
    case CH68 = 'CH68';
    case CH69 = 'CH69';
    case CH70 = 'CH70';
    case CH71 = 'CH71';
    case CH72 = 'CH72';
    case CH73 = 'CH73';
    case CH74 = 'CH74';
    case CH75 = 'CH75';
    case CH76 = 'CH76';
    case CH77 = 'CH77';
    case CH78 = 'CH78';
    case CH79 = 'CH79';
    case CH80 = 'CH80';
    case CH81 = 'CH81';
    case CH82 = 'CH82';
    case CH83 = 'CH83';
    case CH84 = 'CH84';
    case CH85 = 'CH85';
    case CH86 = 'CH86';
    case CH87 = 'CH87';
    case CH88 = 'CH88';
    case CH89 = 'CH89';
    case CH90 = 'CH90';
    case CH91 = 'CH91';
    case CH92 = 'CH92';
    case CH93 = 'CH93';
    case CH94 = 'CH94';
    case CH95 = 'CH95';
    case CH96 = 'CH96';
    case CH97 = 'CH97';
    case CH98 = 'CH98';
    case CH99 = 'CH99';
    case CH100 = 'CH100';
    case CH101 = 'CH101';
    case CH102 = 'CH102';
    case CH103 = 'CH103';
    case CH104 = 'CH104';
    case CH105 = 'CH105';
    case CH106 = 'CH106';
    case CH107 = 'CH107';
    case CH108 = 'CH108';
    case CH109 = 'CH109';
    case CH110 = 'CH110';
    case CH111 = 'CH111';
    case CH112 = 'CH112';
    case CH113 = 'CH113';
    case CH114 = 'CH114';
    case CH115 = 'CH115';
    case CH116 = 'CH116';
    case CH117 = 'CH117';
    case CH118 = 'CH118';
    case CH119 = 'CH119';
    case CH120 = 'CH120';
    case CH121 = 'CH121';
    case CH122 = 'CH122';
    case CH123 = 'CH123';
    case CH124 = 'CH124';
    case CH125 = 'CH125';
    case CH126 = 'CH126';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CH01 => __('report.standard.indicator.cases_health.CH01'),
            self::CH02 => __('report.standard.indicator.cases_health.CH02'),
            self::CH03 => __('report.standard.indicator.cases_health.CH03'),
            self::CH04 => __('report.standard.indicator.cases_health.CH04'),
            self::CH05 => __('report.standard.indicator.cases_health.CH05'),
            self::CH06 => __('report.standard.indicator.cases_health.CH06'),
            self::CH07 => __('report.standard.indicator.cases_health.CH07'),
            self::CH08 => __('report.standard.indicator.cases_health.CH08'),
            self::CH09 => __('report.standard.indicator.cases_health.CH09'),
            self::CH10 => __('report.standard.indicator.cases_health.CH10'),
            self::CH11 => __('report.standard.indicator.cases_health.CH11'),
            self::CH12 => __('report.standard.indicator.cases_health.CH12'),
            self::CH13 => __('report.standard.indicator.cases_health.CH13'),
            self::CH14 => __('report.standard.indicator.cases_health.CH14'),
            self::CH15 => __('report.standard.indicator.cases_health.CH15'),
            self::CH16 => __('report.standard.indicator.cases_health.CH16'),
            self::CH17 => __('report.standard.indicator.cases_health.CH17'),
            self::CH18 => __('report.standard.indicator.cases_health.CH18'),
            self::CH19 => __('report.standard.indicator.cases_health.CH19'),
            self::CH20 => __('report.standard.indicator.cases_health.CH20'),
            self::CH21 => __('report.standard.indicator.cases_health.CH21'),
            self::CH22 => __('report.standard.indicator.cases_health.CH22'),
            self::CH23 => __('report.standard.indicator.cases_health.CH23'),
            self::CH24 => __('report.standard.indicator.cases_health.CH24'),
            self::CH25 => __('report.standard.indicator.cases_health.CH25'),
            self::CH26 => __('report.standard.indicator.cases_health.CH26'),
            self::CH27 => __('report.standard.indicator.cases_health.CH27'),
            self::CH28 => __('report.standard.indicator.cases_health.CH28'),
            self::CH29 => __('report.standard.indicator.cases_health.CH29'),
            self::CH30 => __('report.standard.indicator.cases_health.CH30'),
            self::CH31 => __('report.standard.indicator.cases_health.CH31'),
            self::CH32 => __('report.standard.indicator.cases_health.CH32'),
            self::CH33 => __('report.standard.indicator.cases_health.CH33'),
            self::CH34 => __('report.standard.indicator.cases_health.CH34'),
            self::CH35 => __('report.standard.indicator.cases_health.CH35'),
            self::CH36 => __('report.standard.indicator.cases_health.CH36'),
            self::CH37 => __('report.standard.indicator.cases_health.CH37'),
            self::CH38 => __('report.standard.indicator.cases_health.CH38'),
            self::CH39 => __('report.standard.indicator.cases_health.CH39'),
            self::CH40 => __('report.standard.indicator.cases_health.CH40'),
            self::CH41 => __('report.standard.indicator.cases_health.CH41'),
            self::CH42 => __('report.standard.indicator.cases_health.CH42'),
            self::CH43 => __('report.standard.indicator.cases_health.CH43'),
            self::CH44 => __('report.standard.indicator.cases_health.CH44'),
            self::CH45 => __('report.standard.indicator.cases_health.CH45'),
            self::CH46 => __('report.standard.indicator.cases_health.CH46'),
            self::CH47 => __('report.standard.indicator.cases_health.CH47'),
            self::CH48 => __('report.standard.indicator.cases_health.CH48'),
            self::CH49 => __('report.standard.indicator.cases_health.CH49'),
            self::CH50 => __('report.standard.indicator.cases_health.CH50'),
            self::CH51 => __('report.standard.indicator.cases_health.CH51'),
            self::CH52 => __('report.standard.indicator.cases_health.CH52'),
            self::CH53 => __('report.standard.indicator.cases_health.CH53'),
            self::CH54 => __('report.standard.indicator.cases_health.CH54'),
            self::CH55 => __('report.standard.indicator.cases_health.CH55'),
            self::CH56 => __('report.standard.indicator.cases_health.CH56'),
            self::CH57 => __('report.standard.indicator.cases_health.CH57'),
            self::CH58 => __('report.standard.indicator.cases_health.CH58'),
            self::CH59 => __('report.standard.indicator.cases_health.CH59'),
            self::CH60 => __('report.standard.indicator.cases_health.CH60'),
            self::CH61 => __('report.standard.indicator.cases_health.CH61'),
            self::CH62 => __('report.standard.indicator.cases_health.CH62'),
            self::CH63 => __('report.standard.indicator.cases_health.CH63'),
            self::CH64 => __('report.standard.indicator.cases_health.CH64'),
            self::CH65 => __('report.standard.indicator.cases_health.CH65'),
            self::CH66 => __('report.standard.indicator.cases_health.CH66'),
            self::CH67 => __('report.standard.indicator.cases_health.CH67'),
            self::CH68 => __('report.standard.indicator.cases_health.CH68'),
            self::CH69 => __('report.standard.indicator.cases_health.CH69'),
            self::CH70 => __('report.standard.indicator.cases_health.CH70'),
            self::CH71 => __('report.standard.indicator.cases_health.CH71'),
            self::CH72 => __('report.standard.indicator.cases_health.CH72'),
            self::CH73 => __('report.standard.indicator.cases_health.CH73'),
            self::CH74 => __('report.standard.indicator.cases_health.CH74'),
            self::CH75 => __('report.standard.indicator.cases_health.CH75'),
            self::CH76 => __('report.standard.indicator.cases_health.CH76'),
            self::CH77 => __('report.standard.indicator.cases_health.CH77'),
            self::CH78 => __('report.standard.indicator.cases_health.CH78'),
            self::CH79 => __('report.standard.indicator.cases_health.CH79'),
            self::CH80 => __('report.standard.indicator.cases_health.CH80'),
            self::CH81 => __('report.standard.indicator.cases_health.CH81'),
            self::CH82 => __('report.standard.indicator.cases_health.CH82'),
            self::CH83 => __('report.standard.indicator.cases_health.CH83'),
            self::CH84 => __('report.standard.indicator.cases_health.CH84'),
            self::CH85 => __('report.standard.indicator.cases_health.CH85'),
            self::CH86 => __('report.standard.indicator.cases_health.CH86'),
            self::CH87 => __('report.standard.indicator.cases_health.CH87'),
            self::CH88 => __('report.standard.indicator.cases_health.CH88'),
            self::CH89 => __('report.standard.indicator.cases_health.CH89'),
            self::CH90 => __('report.standard.indicator.cases_health.CH90'),
            self::CH91 => __('report.standard.indicator.cases_health.CH91'),
            self::CH92 => __('report.standard.indicator.cases_health.CH92'),
            self::CH93 => __('report.standard.indicator.cases_health.CH93'),
            self::CH94 => __('report.standard.indicator.cases_health.CH94'),
            self::CH95 => __('report.standard.indicator.cases_health.CH95'),
            self::CH96 => __('report.standard.indicator.cases_health.CH96'),
            self::CH97 => __('report.standard.indicator.cases_health.CH97'),
            self::CH98 => __('report.standard.indicator.cases_health.CH98'),
            self::CH99 => __('report.standard.indicator.cases_health.CH99'),
            self::CH100 => __('report.standard.indicator.cases_health.CH100'),
            self::CH101 => __('report.standard.indicator.cases_health.CH101'),
            self::CH102 => __('report.standard.indicator.cases_health.CH102'),
            self::CH103 => __('report.standard.indicator.cases_health.CH103'),
            self::CH104 => __('report.standard.indicator.cases_health.CH104'),
            self::CH105 => __('report.standard.indicator.cases_health.CH105'),
            self::CH106 => __('report.standard.indicator.cases_health.CH106'),
            self::CH107 => __('report.standard.indicator.cases_health.CH107'),
            self::CH108 => __('report.standard.indicator.cases_health.CH108'),
            self::CH109 => __('report.standard.indicator.cases_health.CH109'),
            self::CH110 => __('report.standard.indicator.cases_health.CH110'),
            self::CH111 => __('report.standard.indicator.cases_health.CH111'),
            self::CH112 => __('report.standard.indicator.cases_health.CH112'),
            self::CH113 => __('report.standard.indicator.cases_health.CH113'),
            self::CH114 => __('report.standard.indicator.cases_health.CH114'),
            self::CH115 => __('report.standard.indicator.cases_health.CH115'),
            self::CH116 => __('report.standard.indicator.cases_health.CH116'),
            self::CH117 => __('report.standard.indicator.cases_health.CH117'),
            self::CH118 => __('report.standard.indicator.cases_health.CH118'),
            self::CH119 => __('report.standard.indicator.cases_health.CH119'),
            self::CH120 => __('report.standard.indicator.cases_health.CH120'),
            self::CH121 => __('report.standard.indicator.cases_health.CH121'),
            self::CH122 => __('report.standard.indicator.cases_health.CH122'),
            self::CH123 => __('report.standard.indicator.cases_health.CH123'),
            self::CH124 => __('report.standard.indicator.cases_health.CH124'),
            self::CH125 => __('report.standard.indicator.cases_health.CH125'),
            self::CH126 => __('report.standard.indicator.cases_health.CH126'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\CasesHealth\\{$this->value}";
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
