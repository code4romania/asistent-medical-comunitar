<?php

declare(strict_types=1);

use App\Models\ICD10AM\ICD10AMDiagnostic;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        ICD10AMDiagnostic::query()
            ->where('name', 'like binary', '%acool%')
            ->update([
                'name' => DB::raw("REPLACE(name, 'acool', 'alcool')"),
            ]);

        ICD10AMDiagnostic::query()
            ->where('name', 'like binary', '%Acool%')
            ->update([
                'name' => DB::raw("REPLACE(name, 'Acool', 'Alcool')"),
            ]);

        Vulnerability::query()
            ->where('id', 'VFC_02')
            ->update([
                'name' => 'Copil din familie cu părinți migranți',
            ]);
    }
};
