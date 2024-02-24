<?php

declare(strict_types=1);

use App\Models\County;
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
        Schema::table('community_activities', function (Blueprint $table) {
            $table->foreignIdFor(County::class)
                ->nullable()
                ->constrained();
        });
    }
};
