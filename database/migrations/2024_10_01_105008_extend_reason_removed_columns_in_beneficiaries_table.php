<?php

declare(strict_types=1);

use App\Enums\Beneficiary\ReasonRemoved;
use App\Models\Beneficiary;
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
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->renameColumn('reason_removed', 'reason_removed_notes');
        });

        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->string('reason_removed')
                ->nullable()
                ->after('family_id');
        });

        Beneficiary::query()
            ->whereNotNull('reason_removed_notes')
            ->whereNull('reason_removed')
            ->update([
                'reason_removed' => ReasonRemoved::OTHER,
            ]);
    }
};
