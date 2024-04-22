<?php

declare(strict_types=1);

use App\Imports\OrphaDiagnosticsImport;
use App\Models\Orpha\OrphaClassificationLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orpha_classification_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('orpha_diagnostics', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->foreignIdFor(OrphaClassificationLevel::class, 'classification_level_id')
                ->constrained('orpha_classification_levels');
        });

        Schema::withoutForeignKeyConstraints(function () {
            Excel::import(new OrphaDiagnosticsImport, database_path('data/orpha.xlsx'));
        });

        // DB::unprepared(
        //     File::get(database_path('data/orpha.sql'))
        // );
    }
};
