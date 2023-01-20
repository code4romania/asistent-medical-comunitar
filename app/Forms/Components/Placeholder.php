<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Forms\Components\Placeholder as BasePlaceholder;
use Illuminate\Support\HtmlString;

class Placeholder extends BasePlaceholder
{
    public function getContent()
    {
        return parent::getContent() ?? new HtmlString('&mdash;');
    }
}
