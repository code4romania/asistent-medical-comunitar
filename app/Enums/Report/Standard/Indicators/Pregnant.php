<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Concerns;

enum Pregnant: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case P01 = 'P01';
    case P02 = 'P02';
    case P03 = 'P03';
    case P04 = 'P04';
    case P05 = 'P05';
    case P06 = 'P06';
    case P07 = 'P07';
    case P08 = 'P08';
    case P09 = 'P09';
    case P10 = 'P10';
    case P11 = 'P11';
    case P12 = 'P12';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.standard.indicator.pregnant';
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\Pregnant\\{$this->value}";
    }
}
