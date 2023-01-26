<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Forms\Components\Placeholder as BasePlaceholder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Placeholder extends BasePlaceholder
{
    public function getContent()
    {
        $content = parent::getContent();

        if (! $content instanceof HtmlString) {
            $content = Str::of($content)
                ->trim()
                ->toHtmlString();
        }

        if ($content->isEmpty()) {
            return new HtmlString('<span class="text-gray-500">&mdash;</span>');
        }

        return $content;
    }
}
