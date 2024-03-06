<?php

declare(strict_types=1);

namespace App\Imports\ICD10AM;

use App\Models\ICD10AM\ICD10AMDiagnostic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ICD10AMDiagnosticsImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    public function model(array $row): ?ICD10AMDiagnostic
    {
        return new ICD10AMDiagnostic([
            'id' => $row['coddiagnostic'],
            'subclass_id' => $row['idsubclasadiagnostic'],
            'name' => $row['numediagnostic'],
        ]);
    }

    public function batchSize(): int
    {
        return 3000;
    }
}
