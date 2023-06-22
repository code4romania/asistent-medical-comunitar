<?php

declare(strict_types=1);

namespace App\Enums\Report\Indicator;

use App\Concerns;

enum GeneralRecord: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case ADULT_NO_MEDICOSOCIAL = 'adult_no_medicosocial';
    case ADULT_WITH_CRONIC_ILLNESS = 'adult_with_cronic_illness';
    case ADULT_WITH_DISABILITIES = 'adult_with_disabilities';
    case ADULT_WITHOUT_FAMILY = 'adult_without_family';

    case FAMILIY_WITH_DOMESTIC_VIOLENCE_CASE = 'familiy_with_domestic_violence_case';
    case WOMAN_FERTILE_AGE = 'woman_fertile_age';
    case WOMAN_POSTPARTUM = 'woman_postpartum';
    case UNDERAGE_MOTHER = 'underage_mother';
    case FAMILY_PLANNING = 'family_planning';
    case PERSON_WITHOUT_GP = 'person_without_gp';

    case ELDERLY = 'elderly';
    case ELDERLY_WITHOUT_FAMILY = 'elderly_without_family';
    case ELDERLY_WITH_CRONIC_ILLNESS = 'elderly_with_cronic_illness';
    case ELDERLY_WITH_DISABILITIES = 'elderly_with_disabilities';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.indicator.value.general_record';
    }
}
