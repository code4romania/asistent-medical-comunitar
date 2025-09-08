<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\Repeater as BaseRepeater;

class Repeater extends BaseRepeater
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->deletable(function (?array $state) {
            if ($this->getMinItems() === null) {
                return true;
            }

            return collect($state)->count() > $this->getMinItems();
        });

        $this->addAction(
            fn (Action $action) => $action
                ->icon('heroicon-s-plus')
                ->color('primary')
                ->link()
        );

        $this->deleteAction(
            fn (Action $action) => $action
                ->requiresConfirmation()
        );
    }

    public function fillFromRelationship(): void
    {
        parent::fillFromRelationship();

        $this->ensureMinItems();
    }

    public function ensureMinItems(): void
    {
        $count = collect($this->getState())->count();

        $minItems = $this->getMinItems();

        if ($minItems === null) {
            return;
        }

        while ($count < $minItems) {
            $this->createItem();

            $count++;
        }
    }

    protected function createItem(): void
    {
        $newUuid = $this->generateUuid();

        $items = $this->getState();

        if ($newUuid) {
            $items[$newUuid] = [];
        } else {
            $items[] = [];
        }

        $this->state($items);

        $this->getChildComponentContainer($newUuid ?? array_key_last($items))->fill();

        $this->collapsed(false, shouldMakeComponentCollapsible: false);
    }
}
