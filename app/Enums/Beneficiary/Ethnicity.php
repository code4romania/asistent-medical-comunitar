<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Ethnicity: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case ROMANIAN = 'romanian';
    case HUNGARIAN = 'hungarian';
    case ROMA = 'roma';
    case UKRAINIAN = 'ukrainian';
    case GERMAN = 'german';
    case LIPOVAN = 'lipovan';
    case TURKISH = 'turkish';
    case TATAR = 'tatar';
    case SERBIAN = 'serbian';
    case OTHER = 'other';

    protected function labelKeyPrefix(): ?string
    {
        return 'beneficiary.ethnicity';
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ROMANIAN => __('beneficiary.ethnicity.romanian'),
            self::HUNGARIAN => __('beneficiary.ethnicity.hungarian'),
            self::ROMA => __('beneficiary.ethnicity.roma'),
            self::UKRAINIAN => __('beneficiary.ethnicity.ukrainian'),
            self::GERMAN => __('beneficiary.ethnicity.german'),
            self::LIPOVAN => __('beneficiary.ethnicity.lipovan'),
            self::TURKISH => __('beneficiary.ethnicity.turkish'),
            self::TATAR => __('beneficiary.ethnicity.tatar'),
            self::SERBIAN => __('beneficiary.ethnicity.serbian'),
            self::OTHER => __('beneficiary.ethnicity.other'),
        };
    }
}
