<?php

declare(strict_types=1);

use App\Imports\ICD10AM\ICD10AMClassImport;
use App\Imports\ICD10AM\ICD10AMDiagnosticsImport;
use App\Imports\ICD10AM\ICD10AMSubclassImport;
use App\Models\ICD10AM\ICD10AMClass;
use App\Models\ICD10AM\ICD10AMSubclass;
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
        Schema::create('icd10am_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('icd10am_subclasses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ICD10AMClass::class, 'class_id')->constrained('icd10am_classes');
            $table->string('name');
        });

        Schema::create('icd10am_diagnostics', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignIdFor(ICD10AMSubclass::class, 'subclass_id')->constrained('icd10am_subclasses');
            $table->string('name');
        });

        Excel::import(new ICD10AMClassImport, database_path('data/icd10am/classes.csv'));
        Excel::import(new ICD10AMSubclassImport, database_path('data/icd10am/subclasses.csv'));
        Excel::import(new ICD10AMDiagnosticsImport, database_path('data/icd10am/diagnostics.csv'));
    }
};
