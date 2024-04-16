<?php

declare(strict_types=1);

use App\Imports\VulnerabilitiesImport;
use App\Models\Catagraphy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration
{
    public function up(): void
    {
        Excel::import(new VulnerabilitiesImport, database_path('data/suspicions.xlsx'));

        Schema::create('suspicions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->json('elements')->nullable();
            $table->string('notes')->nullable();

            $table->foreignIdFor(Catagraphy::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }
};
