<?php

declare(strict_types=1);

namespace App\Filament\Resources\Helps\Pages;

use App\Filament\Resources\Helps\HelpResource;
use Filament\Resources\Pages\Page;

class ViewHelp extends Page
{
    protected static string $resource = HelpResource::class;

    protected string $view = 'filament.resources.help-resource.pages.view-help';

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        return 'Sistem de management de caz pentru asistența medicală comunitară';
    }
}
