<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Activities\ActivityResource;
use Filament\Panel;
use Filament\Resources\Pages\ManageRelatedRecords;

class ListActivities extends ManageRelatedRecords
{
    use UsesParentRecordSubNavigation;
    use HasBreadcrumbs;

    protected static string $resource = BeneficiaryResource::class;

    protected static string $relationship = 'activities';

    protected static ?string $relatedResource = ActivityResource::class;

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
        return __('activity.label');
    }

    public static function getRouteName(?Panel $panel = null): string
    {
        return parent::getRouteName() . '*';
    }
}
