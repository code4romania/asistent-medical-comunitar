<?php

declare(strict_types=1);

use App\Models\ICD10AM\ICD10AMClass;
use App\Models\ICD10AM\ICD10AMSubclass;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

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

        DB::unprepared(
            File::get(database_path('data/icd10am.sql'))
        );
    }
};
