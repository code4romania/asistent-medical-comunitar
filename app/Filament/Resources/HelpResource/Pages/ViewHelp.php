<?php

declare(strict_types=1);

namespace App\Filament\Resources\HelpResource\Pages;

use App\Filament\Resources\HelpResource;
use Filament\Resources\Pages\Page;

class ViewHelp extends Page
{
    protected static string $resource = HelpResource::class;

    protected static string $view = 'filament.resources.help-resource.pages.view-help';

    protected function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getTitle(): string
    {
        return 'Sistem de management de caz pentru asistența medicală comunitară';
    }
}
