<?php

declare(strict_types=1);

use App\Imports\VulnerabilitiesImport;
use Illuminate\Database\Migrations\Migration;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration
{
    public function up(): void
    {
        Excel::import(new VulnerabilitiesImport, database_path('data/rare-diseases.xlsx'));
    }
};
