<?php

declare(strict_types=1);

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
        // For the open-cases widget (interventionable_type + closed_at IS NULL)
        // and the stats trend queries (whereBetween('closed_at')).
        Schema::table('interventions', function (Blueprint $table) {
            $table->index(['interventionable_type', 'closed_at']);
        });

        // For the onlyRealized()/onlyPlanned() correlated `exists (... where status = ?)`.
        Schema::table('interventionable_individual_services', function (Blueprint $table) {
            $table->index('status');
        });

        // For the beneficiary-status report query: the log_name + event filter,
        // plus the LEAD() OVER (PARTITION BY subject_id ORDER BY created_at) window.
        Schema::table('activity_log', function (Blueprint $table) {
            $table->index(
                ['subject_type', 'log_name', 'event', 'subject_id', 'created_at'],
                'activity_log_subject_event_created_at_index'
            );
        });
    }
};
