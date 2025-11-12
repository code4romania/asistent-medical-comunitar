<?php

declare(strict_types=1);

namespace App\Enums\Intervention;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum CaseInitiator: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case NURSE = 'nurse';
    case GP = 'gp';
    case SPECIALIST = 'specialist';
    case TEAM = 'team';
    case DPH = 'dph';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NURSE => __('intervention.initiator.nurse'),
            self::GP => __('intervention.initiator.gp'),
            self::SPECIALIST => __('intervention.initiator.specialist'),
            self::TEAM => __('intervention.initiator.team'),
            self::DPH => __('intervention.initiator.dph'),
            self::OTHER => __('intervention.initiator.other'),
        };
    }
}
