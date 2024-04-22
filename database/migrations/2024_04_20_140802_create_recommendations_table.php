<?php

declare(strict_types=1);

use App\Models\Recommendation;
use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('description')->nullable();
        });

        Schema::create('recommendation_service', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Recommendation::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Service::class)
                ->constrained()
                ->cascadeOnDelete();
        });

        Schema::create('recommendation_vulnerability', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Recommendation::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Vulnerability::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }
};
