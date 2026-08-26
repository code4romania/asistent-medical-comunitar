<?php

declare(strict_types=1);

namespace App\Enums\Intervention;

use App\Models\Intervention;
use App\Models\User;
use CommitGlobal\Enums\Concerns\Comparable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

enum EditRestriction: string
{
    use Comparable;

    case CASE_CLOSED = 'case_closed';
    case PARENT_CASE_CLOSED = 'parent_case_closed';
    case MEDIATOR_ACCESS_RESTRICTED = 'mediator_access_restricted';
    case VULNERABILITY_NOT_CATAGRAPHED = 'vulnerability_not_catagraphed';

    /**
     * Why the given user can no longer edit the given intervention, or `null` when they still can.
     *
     * This is the single source of truth behind `InterventionPolicy::update()` and the callout
     * shown on the intervention view page, so the denial and its explanation cannot drift apart.
     */
    public static function resolve(Intervention $intervention, ?User $user = null): ?self
    {
        $user ??= auth()->user();

        return Cache::driver('array')->remember(
            "intervention-restriction:$intervention->id:$user->id",
            MINUTE_IN_SECONDS,
            function () use ($intervention, $user): ?self {
                if (filled($intervention->parent_id)) {
                    $reason = self::resolve($intervention->parent, $user);

                    if (\is_null($reason)) {
                        return null;
                    }

                    return $reason->is(self::CASE_CLOSED)
                        ? self::PARENT_CASE_CLOSED
                        : $reason;
                }

                if (! $intervention->isOpen()) {
                    return self::CASE_CLOSED;
                }

                if ($user->isMediator() && ! $intervention->mediator_has_access) {
                    return self::MEDIATOR_ACCESS_RESTRICTED;
                }

                $addressesCatagraphedVulnerability = $intervention
                    ->beneficiary
                    ->catagraphy
                    ->all_vulnerabilities_items
                    ->pluck('value')
                    ->contains($intervention->vulnerability_id);

                if (! $addressesCatagraphedVulnerability) {
                    return self::VULNERABILITY_NOT_CATAGRAPHED;
                }

                return null;
            }
        );
    }

    public function getHeading(Intervention $intervention): ?string
    {
        return match ($this) {
            self::CASE_CLOSED => __('intervention.edit_restriction.case_closed.title'),
            self::PARENT_CASE_CLOSED => __('intervention.edit_restriction.parent_case_closed.title'),
            // self::MEDIATOR_ACCESS_RESTRICTED => // not shown in the panel
            self::VULNERABILITY_NOT_CATAGRAPHED => __('intervention.edit_restriction.vulnerability_not_catagraphed.title', [
                'type' => Str::lower(__("intervention.type.{$intervention->interventionable_type}")),
            ]),
            default => null,
        };
    }

    public function getMessage(Intervention $intervention): ?string
    {
        return match ($this) {
            self::CASE_CLOSED => __('intervention.edit_restriction.case_closed.description'),
            self::PARENT_CASE_CLOSED => __('intervention.edit_restriction.parent_case_closed.description'),
            // self::MEDIATOR_ACCESS_RESTRICTED => // not shown in the panel
            self::VULNERABILITY_NOT_CATAGRAPHED => filled($intervention->vulnerability_label)
                ? __('intervention.edit_restriction.vulnerability_not_catagraphed.description', [
                    'vulnerability' => $intervention->vulnerability_label,
                ])
                : __('intervention.edit_restriction.vulnerability_not_catagraphed.description_unknown'),
            default => null,
        };
    }
}
