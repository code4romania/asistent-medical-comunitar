<?php

declare(strict_types=1);

use App\Imports\ServicesImport;
use App\Models\Service\Service;
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
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('is_mediator_only')->default(false);

            $table->unique('code');
        });

        Excel::import(new ServicesImport, database_path('data/260630-mediator-services.xlsx'));

        Service::query()
            ->whereIn('code', [
                'SIO_02', 'SIO_03',
                'SES_15', 'SES_16', 'SES_17', 'SES_18',
                'SID_01', 'SID_02', 'SID_03',
                'SNF_12', 'SNF_13', 'SNF_14', 'SNF_15',
                'SSN_08', 'SSN_09', 'SSN_10', 'SSN_11', 'SSN_12', 'SSN_13', 'SSN_14',
            ])
            ->update([
                'is_mediator_only' => true,
            ]);
    }
};
