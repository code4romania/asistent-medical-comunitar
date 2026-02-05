<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns;

use App\Models\Catagraphy;
use Override;

trait GetRecordFromParentRecord
{
    #[Override]
    public function mount(int | string | null $record = null): void
    {
        $this->record = $this->getRecord();

        $this->authorizeAccess();

        if (! method_exists($this, 'hasInfolist') || ! $this->hasInfolist()) {
            $this->fillForm();
        }
    }

    #[Override]
    public function getRecord(): Catagraphy
    {
        return $this->getParentRecord()->catagraphy;
    }

    #[Override]
    public function hasRecord(): bool
    {
        return filled($this->getRecord());
    }
}
