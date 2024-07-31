<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Concerns;

enum General: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case G01 = 'G01';
    case G02 = 'G02';
    case G03 = 'G03';
    case G04 = 'G04';
    case G05 = 'G05';
    case G06 = 'G06';
    case G07 = 'G07';
    case G08 = 'G08';
    case G09 = 'G09';
    case G10 = 'G10';
    case G11 = 'G11';
    case G12 = 'G12';
    case G13 = 'G13';
    case G14 = 'G14';
    case G15 = 'G15';
    case G16 = 'G16';
    case G17 = 'G17';
    case G18 = 'G18';
    case G19 = 'G19';
    case G20 = 'G20';
    case G21 = 'G21';
    case G22 = 'G22';
    case G23 = 'G23';
    case G24 = 'G24';
    case G25 = 'G25';
    case G26 = 'G26';
    case G27 = 'G27';
    case G28 = 'G28';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.standard.indicator.general';
    }

    public function class(): string
    {
        return "\\App\\Reports\\Standard\\General\\{$this->value}";
    }
}
