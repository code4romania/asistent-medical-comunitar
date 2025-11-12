<?php

declare(strict_types=1);

namespace App\Enums\Employer;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case NGO = 'ngo';
    case DPH = 'dph';
    case GP = 'gp';
    case MUNICIPALITY = 'municipality';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NGO => __('employer.type.ngo'),
            self::DPH => __('employer.type.dph'),
            self::GP => __('employer.type.gp'),
            self::MUNICIPALITY => __('employer.type.municipality'),
            self::OTHER => __('employer.type.other'),
        };
    }
}
