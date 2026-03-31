<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard;

use App\Contracts\Enums\CanBeFiltered;
use App\Enums\Report\Standard\Indicators\Child;
use App\Enums\Report\Standard\Indicators\General;
use App\Enums\Report\Standard\Indicators\Pregnant;
use App\Enums\Report\Standard\Indicators\RareDisease;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Category: string implements HasLabel, CanBeFiltered
{
    use Arrayable;
    use Comparable;

    case GENERAL = 'general';
    case PREGNANT = 'pregnant';
    case CHILD = 'child';
    case RARE_DISEASE = 'rare_disease';

    case USERS = 'users';
    case ACTIVITY = 'activity';
    case INTERVENTIONS = 'interventions';
    case SERVICES_HEALTH = 'services_health';
    case CASES_HEALTH = 'cases_health';
    case COMMUNITY_ACTIVITIES = 'community_activities';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GENERAL => __('report.standard.category.general'),
            self::PREGNANT => __('report.standard.category.pregnant'),
            self::CHILD => __('report.standard.category.child'),
            self::RARE_DISEASE => __('report.standard.category.rare_disease'),

            self::USERS => __('report.standard.category.users'),
            self::ACTIVITY => __('report.standard.category.activity'),
            self::INTERVENTIONS => __('report.standard.category.interventions'),
            self::SERVICES_HEALTH => __('report.standard.category.services_health'),
            self::CASES_HEALTH => __('report.standard.category.cases_health'),
            self::COMMUNITY_ACTIVITIES => __('report.standard.category.community_activities'),
        };
    }

    public function indicator(): string
    {
        return match ($this) {
            self::GENERAL => General::class,
            self::PREGNANT => Pregnant::class,
            self::CHILD => Child::class,
            self::RARE_DISEASE => RareDisease::class,
        };
    }

    public function isVisible(): bool
    {
        // TODO: check for mediator
        return match ($this) {
            self::USERS => auth()->user()->isAdmin() || auth()->user()->isCoordinator(),
            default => true,
        };
    }
}
