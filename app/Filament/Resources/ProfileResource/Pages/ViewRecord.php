<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\ProfileResource\Concerns;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;
use Illuminate\View\View;

class ViewRecord extends BaseViewRecord implements WithTabs
{
    use Concerns\HasTabs;
    use Concerns\ResolvesRecord;

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make()
                ->icon('heroicon-s-pencil')
                ->url($this->getResource()::getUrl("{$this->getActiveTab()}.edit")),
        ];
    }

    protected function getHeader(): View
    {
        return view('profile.header');
    }

    protected function getBreadcrumbs(): array
    {
        return [
            auth()->user()->getFilamentName(),
        ];
    }
}
