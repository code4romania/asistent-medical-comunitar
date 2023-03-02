<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Concerns;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ResolvesRecord
{
    /**
     * Catagraphies are always edited from the beneficiary context, so we need
     * to fetch them through their beneficiary.
     *
     * @param  mixed                                                $key
     * @return \App\Models\Catagraphy
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    protected function resolveRecord(mixed $key): Model
    {
        /** @var Beneficiary|null */
        $record = BeneficiaryResource::resolveRecordRouteBinding($key);

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel($this->getModel(), [$key]);
        }

        return $record;
    }

    public function getRecord(): Model
    {
        return $this->record->catagraphy;
    }
}
