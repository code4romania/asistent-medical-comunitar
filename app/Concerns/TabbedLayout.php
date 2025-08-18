<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Contracts\Pages\WithTabs;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;

trait TabbedLayout
{
    public function bootedTabbedLayout(): void
    {
        if (! $this instanceof WithTabs) {
            return;
        }

        if (! Str::startsWith(static::$view, 'filament-panels::resources.pages')) {
            return;
        }

        static::$view = match (true) {
            $this instanceof ListRecords => 'filament.tabs.list-records',
            $this instanceof CreateRecord => 'filament.tabs.create-record',
            $this instanceof ViewRecord => 'filament.tabs.view-record',
            $this instanceof EditRecord => 'filament.tabs.edit-record',
        };
    }
}
