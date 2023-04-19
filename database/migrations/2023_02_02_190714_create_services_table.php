<?php

declare(strict_types=1);

use App\Imports\ServicesImport;
use App\Models\Service\ServiceCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');

            $table->foreignIdFor(ServiceCategory::class, 'category_id')->constrained('service_categories');
        });

        Schema::withoutForeignKeyConstraints(function () {
            Excel::import(new ServicesImport, database_path('data/services.xlsx'));
        });
    }
};
