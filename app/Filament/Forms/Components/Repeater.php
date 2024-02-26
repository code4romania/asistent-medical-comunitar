<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Repeater as BaseRepeater;
use Illuminate\Support\Str;

class Repeater extends BaseRepeater
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->disableItemDeletion(function (array $state) {
            if ($this->getMinItems() === null) {
                return false;
            }

            return \count($state) <= $this->getMinItems();
        });
    }

    public function fillFromRelationship(): void
    {
        $state = $this->getStateFromRelatedRecords($this->getCachedExistingRecords());

        $this->state($state);

        $this->ensureMinItems($state);
    }

    protected function ensureMinItems(array $state): void
    {
        if ($this->getMinItems() === null) {
            return;
        }

        $count = \count($state);

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
