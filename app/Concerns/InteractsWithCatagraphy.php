<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Filament\Resources\CatagraphyResource;
use App\Models\Catagraphy;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait InteractsWithCatagraphy
{
    protected ?Catagraphy $catagraphy = null;

    protected function resolveCatagraphy(mixed $key): Catagraphy
    {
        /** @var Catagraphy|null */
        $record = CatagraphyResource::resolveRecordRouteBinding($key);

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel(Catagraphy::class, [$key]);
        }

        return $record;
    }

    public function getCatagraphy(): Catagraphy
    {
        return $this->catagraphy;
    }
}
