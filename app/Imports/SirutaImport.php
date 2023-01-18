<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\City;
use App\Models\County;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SirutaImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row): ?Model
    {
        return match ($row['niv']) {
            1 => $this->importCounty($row),
            3 => $this->importCity($row),
            default => null,
        };
    }

    public function batchSize(): int
    {
        return 5000;
    }

    private function importCounty(array $row): Model
    {
        return new County([
            'id'   => $row['fsj'],
            'name' => $this->normalizeName($row['denloc'])
                ->remove(['Județul', 'Municipiul'])
                ->trim(),
        ]);
    }

    private function importCity(array $row): Model
    {
        return new City([
            'county_id' => $row['fsj'],
            'name'      => $this->normalizeName($row['denloc'])
                ->remove('București')
                ->trim(),
        ]);
    }

    private function normalizeName(string $source): Stringable
    {
        return Str::of($source)
            ->replace(['Ţ', 'Ş'], ['Ț', 'Ș'])
            ->title();
    }
}
