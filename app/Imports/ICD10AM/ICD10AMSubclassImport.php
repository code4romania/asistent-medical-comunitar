<?php

declare(strict_types=1);

namespace App\Imports\ICD10AM;

use App\Models\ICD10AM\ICD10AMSubclass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ICD10AMSubclassImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    public function model(array $row): ICD10AMSubclass
    {
        return new ICD10AMSubclass([
            'id' => $row['idsubclasadiagnostic'],
            'class_id' => $row['idclasadiagnostic'],
            'name' => $row['densubclasadiagnostic'],
        ]);
    }

    public function batchSize(): int
    {
        return 250;
    }
}
