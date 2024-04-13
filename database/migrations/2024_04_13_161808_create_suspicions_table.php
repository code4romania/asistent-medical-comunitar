<?php

declare(strict_types=1);

use App\Models\Catagraphy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suspicions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->json('elements')->nullable();
            $table->string('notes')->nullable();

            $table->foreignIdFor(Catagraphy::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }
};
