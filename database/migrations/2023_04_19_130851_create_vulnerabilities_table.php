<?php

declare(strict_types=1);

use App\Imports\VulnerabilitiesImport;
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
        Schema::create('vulnerability_categories', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
        });

        Schema::create('vulnerabilities', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('category_id');

            $table->foreign('category_id')->references('id')->on('vulnerability_categories');
        });

        Schema::withoutForeignKeyConstraints(function () {
            Excel::import(new VulnerabilitiesImport, database_path('data/vulnerabilities.xlsx'));
        });
    }
};
