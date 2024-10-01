<?php

declare(strict_types=1);

use App\Imports\ServicesImport;
use Illuminate\Database\Migrations\Migration;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Excel::import(new ServicesImport, database_path('data/240930-services.xlsx'));
    }
};
