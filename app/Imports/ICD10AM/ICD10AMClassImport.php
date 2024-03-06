<?php

declare(strict_types=1);

namespace App\Imports\ICD10AM;

use App\Models\ICD10AM\ICD10AMClass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ICD10AMClassImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    public function model(array $row): ICD10AMClass
    {
        return new ICD10AMClass([
            'id' => $row['idclasadiagnostic'],
            'name' => $row['denclasadiagnostic'],
        ]);
    }

    public function batchSize(): int
    {
        return 250;
    }
}
