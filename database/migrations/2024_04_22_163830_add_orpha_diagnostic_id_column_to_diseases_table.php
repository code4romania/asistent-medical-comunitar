<?php

declare(strict_types=1);

use App\Models\Orpha\OrphaDiagnostic;
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
        Schema::table('diseases', function (Blueprint $table) {
            $table->foreignIdFor(OrphaDiagnostic::class)
                ->after('diagnostic_id')
                ->nullable()
                ->constrained();
        });
    }
};
