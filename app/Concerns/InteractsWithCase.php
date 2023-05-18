<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Intervention\CaseManagement;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait InteractsWithCase
{
    use InteractsWithRecord;
    use InteractsWithBeneficiary;

    protected function resolveRecord($key): CaseManagement
    {
        $record = app(CaseManagement::class)
            ->resolveRouteBindingQuery($this->record->cases(), $key)
            ->first();

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel(CaseManagement::class, [$key]);
        }

        return $record;
    }

    public function mount(...$args): void
    {
        static::authorizeResourceAccess();

        [$beneficiary, $record] = $args;

        $this->resolveBeneficiary($beneficiary);

        $this->record = app(CaseManagement::class)
            ->resolveRouteBindingQuery($this->getBeneficiary()->cases(), $record)
            ->first();

        $this->fillForm();
    }
}
