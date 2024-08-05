<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Concerns;

enum RareDisease: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case RD01 = 'RD01';
    case RD02 = 'RD02';
    case RD03 = 'RD03';
    case RD04 = 'RD04';
    case RD05 = 'RD05';
    case RD06 = 'RD06';
    case RD07 = 'RD07';
    case RD08 = 'RD08';
    case RD09 = 'RD09';
    case RD10 = 'RD10';
    case RD11 = 'RD11';
    case RD12 = 'RD12';
    case RD13 = 'RD13';
    case RD14 = 'RD14';
    case RD15 = 'RD15';
    case RD16 = 'RD16';
    case RD17 = 'RD17';
    case RD18 = 'RD18';
    case RD19 = 'RD19';
    case RD20 = 'RD20';
    case RD21 = 'RD21';
    case RD22 = 'RD22';
    case RD23 = 'RD23';
    case RD24 = 'RD24';
    case RD25 = 'RD25';
    case RD26 = 'RD26';
    case RD27 = 'RD27';
    case RD28 = 'RD28';
    case RD29 = 'RD29';
    case RD30 = 'RD30';
    case RD31 = 'RD31';
    case RD32 = 'RD32';
    case RD33 = 'RD33';
    case RD34 = 'RD34';
    case RD35 = 'RD35';
    case RD36 = 'RD36';
    case RD37 = 'RD37';
    case RD38 = 'RD38';
    case RD39 = 'RD39';
    case RD40 = 'RD40';
    case RD41 = 'RD41';
    case RD42 = 'RD42';
    case RD43 = 'RD43';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.standard.indicator.rare_disease';
    }

    public function class(): string
    {
        return "\\App\\Reports\\Standard\\RareDisease\\{$this->value}";
    }
}
