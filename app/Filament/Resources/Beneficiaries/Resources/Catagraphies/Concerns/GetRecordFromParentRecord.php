<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns;

trait GetRecordFromParentRecord
{
    public function mount(int | string | null $record = null): void
    {
        $this->record = $this->getParentRecord()->catagraphy;

        $this->authorizeAccess();

        if (! method_exists($this, 'hasInfolist') || ! $this->hasInfolist()) {
            $this->fillForm();
        }
    }
}
