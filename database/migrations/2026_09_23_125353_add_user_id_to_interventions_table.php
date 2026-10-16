<?php

declare(strict_types=1);

use App\Jobs\BackfillInterventionAuthorsJob;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            $table->foreignIdFor(User::class)
                ->nullable()
                ->after('beneficiary_id')
                ->constrained();
        });

        $this->backfill();
    }

    public function backfill(): void
    {
        $minId = DB::table('interventions')->min('id');
        $maxId = DB::table('interventions')->max('id');

        if (is_null($minId)) {
            return;
        }

        $jobs = [];
        $chunkSize = 100_000;

        for ($from = $minId; $from <= $maxId; $from += $chunkSize) {
            $to = min($from + $chunkSize - 1, $maxId);
            $jobs[] = new BackfillInterventionAuthorsJob($from, $to);
        }

        Bus::batch($jobs)
            ->name('Backfill intervention authors')
            ->allowFailures()
            ->dispatch();
    }
};
