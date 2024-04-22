<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Orpha\OrphaClassificationLevel;
use App\Models\Orpha\OrphaDiagnostic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrphaDiagnosticsImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    protected array $classificationLevels = [];

    public function model(array $row): ?OrphaDiagnostic
    {
        return new OrphaDiagnostic([
            'code' => $row['orphacode'],
            'name' => $row['disease_name'],
            'classification_level_id' => $this->getClassificationLevelId($row['classification_level']),
        ]);
    }

    public function batchSize(): int
    {
        return 3000;
    }

    public function getClassificationLevelId(string $name): int
    {
        $level = data_get($this->classificationLevels, $name);

        if (\is_null($level)) {
            $model = OrphaClassificationLevel::firstOrCreate([
                'name' => $name,
            ]);

            data_set($this->classificationLevels, $name, $model->id);

            $level = $model->id;
        }

        return $level;
    }
}
