<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Service\Service;
use App\Models\Service\ServiceCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ServicesImport implements ToCollection, WithHeadingRow
{
    private Collection $categories;

    public function collection(Collection $rows): void
    {
        $this->importCategories($rows);

        Service::insert(
            $rows->map(fn (Collection $row) => [
                'code' => $row['code'],
                'name' => $row['name'],
                'category_id' => $this->categories->get($row['category']),
            ])->toArray()
        );
    }

    private function importCategories(Collection $rows): void
    {
        ServiceCategory::insert(
            $rows->pluck('category')
                ->unique()
                ->map(fn (string $name) => ['name' => $name])
                ->values()
                ->all()
        );

        $this->categories = ServiceCategory::pluck('id', 'name');
    }
}
