<?php

declare(strict_types=1);

use App\Console\Commands\BackfillActivityLogBeneficiaryIdCommand;
use App\Models\Beneficiary;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->foreignIdFor(Beneficiary::class)
                ->nullable()
                ->after('causer_id')
                ->constrained()
                ->nullOnDelete();
        });

        Artisan::call(BackfillActivityLogBeneficiaryIdCommand::class);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropForeign(['beneficiary_id']);
            $table->dropColumn('beneficiary_id');
        });
    }
};
