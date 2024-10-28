<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VulnerabilitiesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows): void
    {
        if ($rows->first()?->count() === 2) {
            VulnerabilityCategory::upsert($rows->toArray(), 'id');
        } else {
            Vulnerability::upsert(
                $rows->map(fn (Collection $row) => [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'category_id' => $row['category'],
                ])->toArray(),
                'id'
            );
        }
    }
}
