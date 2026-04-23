<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard;

use App\Contracts\Enums\CanBeFiltered;
use App\Enums\Report\Type;
use App\Enums\User\Role;
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
            self::GENERAL => Indicators\General::class,
            self::PREGNANT => Indicators\Pregnant::class,
            self::CHILD => Indicators\Child::class,
            self::RARE_DISEASE => Indicators\RareDisease::class,

            self::USERS => Indicators\Users::class,
            self::ACTIVITY => Indicators\Activity::class,
            self::INTERVENTIONS => Indicators\Interventions::class,
            self::SERVICES_HEALTH => Indicators\ServicesHealth::class,
            self::CASES_HEALTH => Indicators\CasesHealth::class,
            self::COMMUNITY_ACTIVITIES => Indicators\CommunityActivities::class,
        };
    }

    public function getColumns(Type $type, Role $role): array
    {
        return collect($this->indicator()::columns($type, $role))
            ->map(function (array|string $label, string $name): array {
                if (\is_array($label)) {
                    return $label;
                }

                return [
                    'name' => $name,
                    'label' => $label,
                ];
            })
            ->values()
            ->toArray();
    }

    public function isVisible(?Type $type = null): bool
    {
        if (
            filled($type) &&
            ! \in_array($type, $this->indicator()::types(), true)
        ) {
            return false;
        }

        // TODO: check for mediator
        return match ($this) {
            self::USERS => auth()->user()->isAdmin() || auth()->user()->isCoordinator(),
            self::SERVICES_HEALTH => auth()->user()->isNurse(), // TODO: remove when the report will be available for all roles
            default => true,
        };
    }
}
