<?php

declare(strict_types=1);

use App\Models\Catagraphy;
use App\Models\ICD10AM\ICD10AMDiagnostic;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disabilities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('type')->nullable();
            $table->string('degree')->nullable();
            $table->boolean('receives_pension')->default(false);
            $table->boolean('has_certificate')->default(false);
            $table->year('start_year')->nullable();
            $table->string('notes')->nullable();

            $table->foreignIdFor(ICD10AMDiagnostic::class, 'diagnostic_id')
                ->nullable()
                ->constrained('icd10am_diagnostics');

            $table->foreignIdFor(Catagraphy::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }
};
