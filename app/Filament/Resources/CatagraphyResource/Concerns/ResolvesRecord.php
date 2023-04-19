<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Concerns;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\Catagraphy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Catagraphies are always edited from the beneficiary context, so we need
 * to fetch them through their beneficiary.
 */
trait ResolvesRecord
{
    protected function resolveRecord(mixed $key): Model
    {
        /** @var Beneficiary|null */
        $record = BeneficiaryResource::resolveRecordRouteBinding($key);

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel($this->getModel(), [$key]);
        }

        return $record;
    }

    public function getRecord(): Catagraphy
    {
        return $this->record->catagraphy;
    }

    public function getBeneficiary(): Beneficiary
    {
        return $this->record;
    }
}
