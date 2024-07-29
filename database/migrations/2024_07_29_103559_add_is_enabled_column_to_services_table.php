<?php

declare(strict_types=1);

use App\Models\Service\Service;
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
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('is_enabled')->default(true);
        });

        Service::query()
            ->whereIn('code', [
                'SAA_01', 'SAA_02', 'SAA_03', 'SAA_04', 'SAA_05', 'SAA_06',
                'SNA_01', 'SNA_02', 'SNA_03', 'SNA_04', 'SNA_05',
                'SAN_01', 'SAN_02', 'SAN_03',
            ])
            ->update([
                'is_enabled' => false,
            ]);
    }
};
