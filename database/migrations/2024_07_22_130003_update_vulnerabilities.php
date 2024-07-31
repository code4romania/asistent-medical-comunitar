<?php

declare(strict_types=1);

use App\Imports\VulnerabilitiesImport;
use Illuminate\Database\Migrations\Migration;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Excel::import(new VulnerabilitiesImport, database_path('data/240722-vulnerabilities.xlsx'));
    }
};
