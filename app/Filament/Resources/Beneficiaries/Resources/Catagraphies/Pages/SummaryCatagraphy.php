<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\DisableNavigationIcon;
use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\CatagraphyResource;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns\GetRecordFromParentRecord;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Schemas\SummaryInfolist;
use Filament\Panel;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SummaryCatagraphy extends ViewRecord
{
    use DisableNavigationIcon;
    use HasBreadcrumbs;
    use GetRecordFromParentRecord;
    use UsesParentRecordSubNavigation;

    protected static string $resource = CatagraphyResource::class;

    public function getTitle(): string
    {
        return static::getNavigationLabel();
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public static function getNavigationLabel(): string
    {
        return __('beneficiary.section.catagraphy');
    }

    public static function getRouteName(?Panel $panel = null): string
    {
        return Str::beforeLast(parent::getRouteName(), '.') . '*';
    }

    public function infolist(Schema $schema): Schema
    {
        return SummaryInfolist::configure($schema);
    }
}
