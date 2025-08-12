<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Forms\Components\Repeater as BaseRepeater;
use Illuminate\Support\Str;

class Repeater extends BaseRepeater
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->disableItemDeletion(function (?array $state) {
            if ($this->getMinItems() === null) {
                return false;
            }

            return collect($state)->count() <= $this->getMinItems();
        });
    }

    public function fillFromRelationship(): void
    {
        parent::fillFromRelationship();

        $this->ensureMinItems();
    }

    public function ensureMinItems(): void
    {
        $count = $this->getMinItems()
            ? collect($this->getState())->count()
            : 1;

        while ($count < $this->getMinItems()) {
            $this->createItem();

            $count++;
        }
    }

    private function createItem(): void
    {
        $newUuid = (string) Str::uuid();
        $livewire = $this->getLivewire();

        data_set($livewire, "{$this->getStatePath()}.{$newUuid}", []);

        $this->getChildComponentContainers()[$newUuid]->fill();

        $this->collapsed(false, shouldMakeComponentCollapsible: false);
    }
}
