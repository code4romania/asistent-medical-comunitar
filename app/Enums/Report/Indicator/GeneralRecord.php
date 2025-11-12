<?php

declare(strict_types=1);

namespace App\Enums\Report\Indicator;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum GeneralRecord: string implements HasLabel
{
    use Arrayable;
    use Comparable;

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

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADULT_NO_MEDICOSOCIAL => __('report.indicator.value.general_record.adult_no_medicosocial'),
            self::ADULT_WITH_CRONIC_ILLNESS => __('report.indicator.value.general_record.adult_with_cronic_illness'),
            self::ADULT_WITH_DISABILITIES => __('report.indicator.value.general_record.adult_with_disabilities'),
            self::ADULT_WITHOUT_FAMILY => __('report.indicator.value.general_record.adult_without_family'),

            self::FAMILIY_WITH_DOMESTIC_VIOLENCE_CASE => __('report.indicator.value.general_record.familiy_with_domestic_violence_case'),
            self::WOMAN_FERTILE_AGE => __('report.indicator.value.general_record.woman_fertile_age'),
            self::WOMAN_POSTPARTUM => __('report.indicator.value.general_record.woman_postpartum'),
            self::UNDERAGE_MOTHER => __('report.indicator.value.general_record.underage_mother'),
            self::FAMILY_PLANNING => __('report.indicator.value.general_record.family_planning'),
            self::PERSON_WITHOUT_GP => __('report.indicator.value.general_record.person_without_gp'),

            self::ELDERLY => __('report.indicator.value.general_record.elderly'),
            self::ELDERLY_WITHOUT_FAMILY => __('report.indicator.value.general_record.elderly_without_family'),
            self::ELDERLY_WITH_CRONIC_ILLNESS => __('report.indicator.value.general_record.elderly_with_cronic_illness'),
            self::ELDERLY_WITH_DISABILITIES => __('report.indicator.value.general_record.elderly_with_disabilities'),
        };
    }
}
