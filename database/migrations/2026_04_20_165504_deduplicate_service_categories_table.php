<?php

declare(strict_types=1);

use App\Models\Service\Service;
use App\Models\Service\ServiceCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        ServiceCategory::all()
            ->map(function (ServiceCategory $category): ServiceCategory {
                $category->name = Str::trim($category->name);

                return $category;
            })
            ->groupBy('name')
            ->map->pluck('id')
            ->each(function (Collection $services): void {
                if (count($services) === 1) {
                    return;
                }

                $keep = $services->shift();

                Service::query()
                    ->whereIn('category_id', $services)
                    ->update([
                        'category_id' => $keep,
                    ]);

                ServiceCategory::query()
                    ->whereIn('id', $services)
                    ->delete();
            });
    }
};
