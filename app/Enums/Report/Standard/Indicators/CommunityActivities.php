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

enum CommunityActivities: string implements HasQuery, HasLabel, HasTypes, HasColumns
{
    use Arrayable;
    use Comparable;

    case CA01 = 'CA01';
    case CA02 = 'CA02';
    case CA03 = 'CA03';
    case CA04 = 'CA04';
    case CA05 = 'CA05';
    case CA06 = 'CA06';
    case CA07 = 'CA07';
    case CA08 = 'CA08';
    case CA09 = 'CA09';
    case CA10 = 'CA10';
    case CA11 = 'CA11';
    case CA12 = 'CA12';
    case CA13 = 'CA13';
    case CA14 = 'CA14';
    case CA15 = 'CA15';
    case CA16 = 'CA16';
    case CA17 = 'CA17';
    case CA18 = 'CA18';
    case CA19 = 'CA19';
    case CA20 = 'CA20';
    case CA21 = 'CA21';
    case CA22 = 'CA22';
    case CA23 = 'CA23';
    case CA24 = 'CA24';
    case CA25 = 'CA25';
    case CA26 = 'CA26';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CA01 => __('report.standard.indicator.community_activities.CA01'),
            self::CA02 => __('report.standard.indicator.community_activities.CA02'),
            self::CA03 => __('report.standard.indicator.community_activities.CA03'),
            self::CA04 => __('report.standard.indicator.community_activities.CA04'),
            self::CA05 => __('report.standard.indicator.community_activities.CA05'),
            self::CA06 => __('report.standard.indicator.community_activities.CA06'),
            self::CA07 => __('report.standard.indicator.community_activities.CA07'),
            self::CA08 => __('report.standard.indicator.community_activities.CA08'),
            self::CA09 => __('report.standard.indicator.community_activities.CA09'),
            self::CA10 => __('report.standard.indicator.community_activities.CA10'),
            self::CA11 => __('report.standard.indicator.community_activities.CA11'),
            self::CA12 => __('report.standard.indicator.community_activities.CA12'),
            self::CA13 => __('report.standard.indicator.community_activities.CA13'),
            self::CA14 => __('report.standard.indicator.community_activities.CA14'),
            self::CA15 => __('report.standard.indicator.community_activities.CA15'),
            self::CA16 => __('report.standard.indicator.community_activities.CA16'),
            self::CA17 => __('report.standard.indicator.community_activities.CA17'),
            self::CA18 => __('report.standard.indicator.community_activities.CA18'),
            self::CA19 => __('report.standard.indicator.community_activities.CA19'),
            self::CA20 => __('report.standard.indicator.community_activities.CA20'),
            self::CA21 => __('report.standard.indicator.community_activities.CA21'),
            self::CA22 => __('report.standard.indicator.community_activities.CA22'),
            self::CA23 => __('report.standard.indicator.community_activities.CA23'),
            self::CA24 => __('report.standard.indicator.community_activities.CA24'),
            self::CA25 => __('report.standard.indicator.community_activities.CA25'),
            self::CA26 => __('report.standard.indicator.community_activities.CA26'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\CommunityActivity\\{$this->value}";
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
