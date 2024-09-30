<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;

enum Ethnicity: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

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
}
